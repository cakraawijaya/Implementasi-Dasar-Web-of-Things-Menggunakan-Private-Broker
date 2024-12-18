[![Open Source Love](https://badges.frapsoft.com/os/v1/open-source.svg?style=flat)](https://github.com/ellerbrock/open-source-badges/)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg?logo=github&color=%23F7DF1E)](https://opensource.org/licenses/MIT)
![GitHub last commit](https://img.shields.io/github/last-commit/cakraawijaya/Implementasi-Dasar-Web-of-Things-Menggunakan-Private-Broker?logo=Codeforces&logoColor=white&color=%23F7DF1E)
![Project](https://img.shields.io/badge/Project-Website-light.svg?style=flat&logo=googlechrome&logoColor=white&color=%23F7DF1E)
![Type](https://img.shields.io/badge/Type-Bootcamp-light.svg?style=flat&logo=gitbook&logoColor=white&color=%23F7DF1E)

# Implementasi-Dasar-Web-of-Things-Menggunakan-Private-Broker

Segera Hadir...

<br>

## Project Requirements

| Part | Description |
| --- | --- |
| Fitur | • Publish<br>• Subscribe<br>• Buat<br>• Baca<br>• Ubah<br>• Hapus<br>• Paginasi<br>• Cari<br>• Validasi<br>• Cetak<br>• Ekspor<br>• DLL |
| Papan Pengembangan | DOIT ESP32 DEVKIT V1 |
| Editor Kode | • Arduino IDE<br>• Visual Studio Code |
| Dukungan Aplikasi | Laragon |
| Driver | CP210X USB Driver |
| Platform IoT | Shiftr.io |
| Protokol Komunikasi | • WebSocket Secure (WSS)<br>• Message Queuing Telemetry Transport (MQTT)<br>• Simple Mail Transfer Protocol (SMTP) |
| Arsitektur IoT | 3 Lapisan |
| Kerangka Kerja | AdminLTE v3.2.0 |
| Pustaka Web | • MQTT.js<br>• PHPMailer |
| Pustaka Arduino | • WiFi (bawaan)<br>• Servo<br>• DHT_sensor_library_for_ESPx<br>• Nusabot Simple Timer |
| Aktuator | • Motor Servo SG90 180° (x1)<br>• LED (x1)<br>• LED RGB (x1) |
| Sensor | • DHT22: Suhu & Kelembaban Udara (x1)<br>• LDR: Cahaya (x1) |
| Komponen Lainnya | • Kabel USB Mikro - USB tipe A (x1)<br>• Kabel jumper (1 set)<br>• Breadboard (x1)<br>• Resistor (x1) |

<br><br>

## Unduh & Instal

1. Arduino IDE

   <table><tr><td width="810">

   ```
   https://www.arduino.cc/en/software
   ```

   </td></tr></table><br>

2. CP210X USB Driver

   <table><tr><td width="810">

   ```
   https://bit.ly/CP210X_USB_Driver
   ```

   </td></tr></table><br>

3. Visual Studio Code

   <table><tr><td width="810">

   ```
   https://bit.ly/VScode_Installer
   ```

   </td></tr></table><br>

4. Laragon

   <table><tr><td width="810">

   ```
   https://laragon.org/download/
   ```

   </td></tr></table><br>

5. AdminLTE v3.2.0

   <table><tr><td width="810">

   ```
   https://codeload.github.com/ColorlibHQ/AdminLTE/zip/refs/tags/v3.2.0
   ```

   </td></tr></table>

<br><br>

## Rancangan Proyek

Segera Hadir...

<br><br>

## Pengaturan Arduino IDE

Segera Hadir...

<br><br>

## Pengaturan Private Broker

Segera Hadir...

<br><br>

## Basis Data
1. Buka ``` Laragon ```, kemudian instal ``` phpMyAdmin ```. Cara instal: klik tombol ``` Menu ``` -> ``` Tools ``` -> ``` Quick add ``` -> ``` *phpmyadmin ```.<br><br>

2. Kemudian jika sudah, klik tombol ``` Start All ``` untuk memulai server secara lokal.<br><br>

3. Akses ``` peramban ``` terlebih dahulu untuk membuka panel admin basis data, silakan salin tautan berikut: ``` localhost/phpmyadmin/ ```.<br><br>
   
3. Buat basis data bernama ``` sistem_iot ``` di lokal.<br><br>

4. Buka basis data ``` sistem_iot ``` dan Impor ``` sistem_iot.sql ``` di direktori ``` sistemiot/dist/sql ```.<br><br>

<br><br>

## Akun Bawaan
| Peran | Nama Pengguna | Kata Sandi |
| --- | --- | --- |
| Admin | linling | admin123 |
| User | albert | user123 |

<br><br>

## Get Started

Segera Hadir...

<br><br>

## Sorotan

Segera Hadir...

<br><br>

## Setel Ulang Increment Basis Data

<table><tr><td width="840">
   
```sql
SET  @num := 0;
UPDATE your_table SET id = @num := (@num+1);
ALTER TABLE your_table AUTO_INCREMENT =1;
```

</td></tr></table>

<br><br>

## Appreciation

Jika karya ini bermanfaat bagi anda, maka dukunglah karya ini sebagai bentuk apresiasi kepada penulis dengan mengklik tombol ``` ⭐Bintang ``` di bagian atas repositori.

<br><br>

## Penafian

Aplikasi ini merupakan hasil pengembangan dari Bootcamp Nusabot. Saya tidak memungkiri bahwa saya masih menggunakan layanan pihak ketiga dalam pengerjaan ini, antara lain: library, framework, dan lain sebagainya.

<br><br>

## LISENSI

LISENSI MIT - Hak Cipta © 2024 - Devan C. M. Wijaya, S.Kom

Dengan ini diberikan izin tanpa biaya kepada siapa pun yang mendapatkan salinan perangkat lunak ini dan file dokumentasi terkait perangkat lunak untuk menggunakannya tanpa batasan, termasuk namun tidak terbatas pada hak untuk menggunakan, menyalin, memodifikasi, menggabungkan, mempublikasikan, mendistribusikan, mensublisensikan, dan/atau menjual salinan Perangkat Lunak ini, dan mengizinkan orang yang menerima Perangkat Lunak ini untuk dilengkapi dengan persyaratan berikut:

Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus menyertai semua salinan atau bagian penting dari Perangkat Lunak.

DALAM HAL APAPUN, PENULIS ATAU PEMEGANG HAK CIPTA DI SINI TETAP MEMILIKI HAK KEPEMILIKAN PENUH. PERANGKAT LUNAK INI DISEDIAKAN SEBAGAIMANA ADANYA, TANPA JAMINAN APAPUN, BAIK TERSURAT MAUPUN TERSIRAT, OLEH KARENA ITU JIKA TERJADI KERUSAKAN, KEHILANGAN, ATAU LAINNYA YANG TIMBUL DARI PENGGUNAAN ATAU URUSAN LAIN DALAM PERANGKAT LUNAK INI, PENULIS ATAU PEMEGANG HAK CIPTA TIDAK BERTANGGUNG JAWAB, KARENA PENGGUNAAN PERANGKAT LUNAK INI TIDAK DIPAKSAKAN SAMA SEKALI, SEHINGGA RISIKO ADALAH MILIK ANDA SENDIRI.
