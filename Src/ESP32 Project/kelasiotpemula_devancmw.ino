// Library
#include <WiFi.h>
#include <MQTT.h>
#include <ESP32Servo.h>
#include <NusabotSimpleTimer.h>
#include <DHTesp.h>

// Pembuatan Objek
WiFiClient net;
MQTTClient client;
Servo servo;
NusabotSimpleTimer timer;
DHTesp dhtSensor;

// Network
const char ssid[] = "YOUR_WIFI_NAME";
const char pass[] = "YOUR_WIFI_PASSWORD";
const char brokerName[] = "YOUR_SHIFTR_IO_DOMAIN";
const char username_account[] = "YOUR_SHIFTR_IO_ACCOUNT_USERNAME";
const char password_account[] = "YOUR_SHIFTR_IO_ACCOUNT_PASSWORD";
const char clientID[] = "YOUR_CLIENT_ID";

// Serial Number dan Topic MQTT
const String serial_number = "YOUR_SERIAL_NUMBER"; // Harus diisi 8 kata (sudah saya tetapkan)
const String topicLed = "kelasiot/"+serial_number+"/led";
const String topicServo = "kelasiot/"+serial_number+"/servo";
const String topicIntensitasCahaya = "kelasiot/"+serial_number+"/intensitas_cahaya";
const String topicSuhu = "kelasiot/"+serial_number+"/suhu";
const String topicKelembapan = "kelasiot/"+serial_number+"/kelembapan";
const String topicStatus = "kelasiot/status/"+serial_number;
const String subTopic = "kelasiot/#";

// Nomor pin GPIO
const byte pinRed = 2;
const byte pinGreen = 4;
const byte pinBlue = 16;
const byte pinLED = 13;
const byte pinServo = 18;
const byte pinLDR = 33;
const byte pinDHT = 25;

// Variabel Global
int adcLDR = 0;
int oldCahaya = 0;
int oldSuhu = 0;
int oldKelembapan = 0;
const float R_FIXED = 10.0;
const float calibrationValue = 1.2;
float volt, resistance, lux, suhu, kelembapan;
int cahaya;

// Method ini dijalankan sekali saat perangkat ESP dinyalakan
void setup() {
  pinMode(pinRed, OUTPUT);
  pinMode(pinGreen, OUTPUT);
  pinMode(pinBlue, OUTPUT);
  pinMode(pinLED, OUTPUT);
  servo.attach(pinServo, 500, 2400);
  pinMode(pinLDR, INPUT);
  dhtSensor.setup(pinDHT, DHTesp::DHT11);
  
  WiFi.begin(ssid, pass);
  client.begin(brokerName, net);

  client.onMessage(subscribe);
  timer.setInterval(1000, publishLDR);
  timer.setInterval(2000, publishDHT);

  connect();
}

// Method ini dijalankan berulang kali saat perangkat ESP dinyalakan
void loop() {
  client.loop();
  timer.run();
  if(!client.connected()){
    connect();
  }
  delay(10);
}

// Method ini untuk Subscribe Topic LED dan Servo
void subscribe(String &topic, String &data){
  if(topic == topicLed){
    if(data == "nyala"){
      digitalWrite(pinLED, 1);
    } else if(data == "mati"){
      digitalWrite(pinLED, 0);
    }
  }

  if(topic == topicServo){
    int posServo = data.toInt();
    servo.write(posServo);
  }
}

// Method ini untuk Publish Topic sensor LDR
void publishLDR(){
  adcLDR = analogRead(pinLDR);
  volt = (adcLDR / 4095.0) * 3.3;
  resistance = (3.3 * R_FIXED / volt) - R_FIXED;
  lux = 500 / pow(resistance / 1000, calibrationValue);
  cahaya = lux;

  if(cahaya >= 100000){
    cahaya = 100000;
  }

  if(cahaya < 0){
    cahaya = 0;
  }
  
  if(cahaya != oldCahaya){
    client.publish(topicIntensitasCahaya, String(cahaya), true, 1);
    oldCahaya = cahaya;
  }
}

// Method ini untuk Publish Topic sensor DHT
void publishDHT(){
  TempAndHumidity data = dhtSensor.getTempAndHumidity();

  suhu = data.temperature;
  kelembapan = data.humidity;

  if(suhu != oldSuhu){
    client.publish(topicSuhu, String(suhu, 1), true, 1);
    oldSuhu = suhu;
  }

  if(kelembapan != oldKelembapan){
    client.publish(topicKelembapan, String(kelembapan, 1), true, 1);
    oldKelembapan = kelembapan;
  }
}

// Method RGB LED digunakan sebagai indikator koneksi
void rgb(bool red, bool green, bool blue){
  digitalWrite(pinRed, red);
  digitalWrite(pinGreen, green);
  digitalWrite(pinBlue, blue);
}

// Method ini untuk melakukan Koneksi
void connect(){
  rgb(1,0,0); // Merah
  while(WiFi.status() != WL_CONNECTED){
    delay(500);
  }
  rgb(0,1,0); // Hijau

  client.setWill(topicStatus.c_str(), "Offline", true, 1);
  while(!client.connect(clientID, username_account, password_account)){
    delay(500);
  }

  rgb(0,0,1); // Biru
  client.publish(topicStatus.c_str(), "Online", true, 1);
  client.subscribe(subTopic, 1);  // Subscribe menggunakan QoS 1
}
