<?php

namespace Database\Seeders;

use App\Models\Materi;
use Illuminate\Database\Seeder;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        Materi::query()->delete();

        $data = [
            [
                'bab' => 'Bab 1',
                'judul' => 'Berpikir Komputasional',
                'deskripsi' => "Berpikir komputasional adalah cara berpikir untuk menyelesaikan masalah secara runtut, logis, dan dapat dijalankan oleh manusia maupun komputer. Dalam proses ini, masalah besar dipecah menjadi bagian-bagian kecil, pola yang muncul dikenali, informasi penting dipilih, lalu langkah penyelesaian disusun dengan jelas.\n\nSalah satu penerapan berpikir komputasional adalah pencarian data. Pencarian data digunakan untuk menemukan informasi tertentu dari sekumpulan data. Pencarian dapat dilakukan dengan memeriksa data satu per satu atau memakai strategi yang lebih cepat apabila data sudah tersusun dengan baik.\n\nSelain pencarian, pengurutan data juga penting. Pengurutan membantu informasi menjadi lebih mudah dibaca, dibandingkan, dan dicari. Dalam pengurutan, data disusun berdasarkan aturan tertentu, misalnya dari nilai terkecil ke terbesar, dari abjad awal ke akhir, atau berdasarkan prioritas tertentu.\n\nMateri ini juga mengenalkan tumpukan dan antrean sebagai struktur data sederhana. Tumpukan bekerja seperti susunan benda yang diambil dari bagian paling atas, sedangkan antrean bekerja seperti barisan orang yang dilayani dari urutan paling depan.",
                'video_url' => '',
            ],
            [
                'bab' => 'Bab 2',
                'judul' => 'Algoritma dan Pemrograman',
                'deskripsi' => "Algoritma adalah urutan langkah yang jelas untuk menyelesaikan masalah. Sebelum membuat program, penyelesaian masalah perlu dirancang terlebih dahulu agar alurnya benar, mudah dipahami, dan dapat diikuti oleh komputer.\n\nRancangan program dapat ditulis menggunakan pseudocode. Pseudocode adalah penulisan langkah program dengan bahasa sederhana yang mendekati bahasa komputer. Dengan pseudocode, siswa dapat fokus pada logika penyelesaian masalah tanpa harus langsung memikirkan aturan bahasa pemrograman tertentu.\n\nProgram umumnya memiliki bagian input, proses, dan output. Input digunakan untuk menerima data, proses digunakan untuk mengolah data, sedangkan output digunakan untuk menampilkan hasil. Dalam pemrograman, siswa juga mengenal variabel, operator, percabangan, dan perulangan.\n\nPemrograman prosedural menyusun program sebagai kumpulan perintah yang dijalankan secara berurutan. Program yang baik perlu memiliki langkah yang jelas, mudah diuji, dan dapat diperbaiki apabila terjadi kesalahan.",
                'video_url' => '',
            ],
            [
                'bab' => 'Bab 3',
                'judul' => 'Sistem Komputer',
                'deskripsi' => "Komputer terdiri dari beberapa komponen utama, yaitu perangkat input, perangkat proses, perangkat penyimpanan, dan perangkat output. Setiap komponen memiliki peran yang berbeda, tetapi semuanya saling bekerja sama agar komputer dapat menjalankan perintah pengguna.\n\nKomputer bekerja melalui alur input, proses, dan output. Input adalah data atau perintah yang diberikan pengguna. Proses adalah pengolahan data oleh komputer. Output adalah hasil yang ditampilkan dalam bentuk informasi, seperti teks, gambar, suara, atau tampilan pada layar.\n\nInteraksi manusia dan komputer terjadi melalui antarmuka. Antarmuka dapat berupa tombol, menu, ikon, papan ketik, layar sentuh, atau tampilan grafis lainnya. Antarmuka yang baik membantu pengguna memberi perintah dan memahami hasil kerja komputer dengan lebih mudah.\n\nSistem operasi berperan sebagai penghubung antara pengguna, aplikasi, dan perangkat keras. Sistem operasi mengelola proses, memori, penyimpanan, perangkat, serta membantu aplikasi berjalan dengan baik.",
                'video_url' => '',
            ],
            [
                'bab' => 'Bab 4',
                'judul' => 'Pencarian Informasi Digital',
                'deskripsi' => "Pencarian informasi digital perlu diawali dengan kata kunci yang tepat. Kata kunci membantu mesin pencari menampilkan informasi yang sesuai kebutuhan. Siswa perlu memilih kata penting, mempersempit hasil pencarian, dan menyesuaikan kata kunci dengan topik yang ingin dicari.\n\nTidak semua informasi di internet dapat dipercaya. Karena itu, sumber informasi perlu dipilih dengan hati-hati. Hal yang dapat diperhatikan antara lain penulis, lembaga penerbit, tanggal publikasi, alamat situs, dan kesesuaian isi dengan kebutuhan.\n\nPemeriksaan fakta dilakukan untuk memastikan informasi tidak keliru atau menyesatkan. Siswa perlu membandingkan informasi dari beberapa sumber, melihat bukti pendukung, dan tidak langsung percaya pada judul atau gambar yang menarik perhatian.\n\nMembaca lateral adalah cara menilai informasi dengan membuka sumber lain di luar halaman yang sedang dibaca. Teknik ini membantu siswa mengetahui latar belakang situs, kredibilitas penulis, dan kebenaran informasi secara lebih objektif.",
                'video_url' => '',
            ],
            [
                'bab' => 'Bab 5',
                'judul' => 'Teknologi Informasi dan Komunikasi',
                'deskripsi' => "Teknologi Informasi dan Komunikasi membantu siswa membuat, mengolah, menyimpan, dan menyampaikan informasi secara digital. Aplikasi pengolah kata, spreadsheet, dan presentasi dapat digunakan secara terpadu agar pekerjaan menjadi lebih efisien.\n\nDokumen digital perlu disusun dengan rapi agar mudah dibaca. Dalam membuat dokumen, siswa dapat menggunakan judul, paragraf, tabel, gambar, daftar isi, serta pengaturan format agar informasi tersampaikan dengan jelas.\n\nSpreadsheet dapat digunakan untuk menyimpan, menghitung, dan menganalisis data sederhana. Siswa dapat memakai tabel, rumus, dan grafik agar data lebih mudah dipahami serta dapat membantu dalam pengambilan keputusan.\n\nPresentasi digunakan untuk menyampaikan informasi kepada orang lain. Presentasi yang baik perlu memuat isi penting, susunan slide yang jelas, visual yang sesuai, dan bahasa yang mudah dipahami audiens.",
                'video_url' => '',
            ],
            [
                'bab' => 'Bab 6',
                'judul' => 'Jaringan Komputer dan Internet',
                'deskripsi' => "Jaringan komputer memungkinkan beberapa perangkat saling terhubung untuk berbagi data, sumber daya, dan layanan. Jaringan dapat berupa jaringan lokal maupun internet. Koneksi dapat menggunakan kabel atau nirkabel sesuai kebutuhan.\n\nKomunikasi data terjadi saat data dikirim dari pengirim ke penerima melalui media tertentu. Dalam komunikasi data terdapat pengirim, penerima, pesan, media transmisi, dan aturan komunikasi agar data dapat sampai dengan benar.\n\nPerangkat dapat terhubung ke internet melalui Wi-Fi, jaringan seluler, kabel, atau perangkat jaringan lainnya. Setiap jenis koneksi memiliki manfaat dan risiko, sehingga pengguna perlu memahami cara menggunakannya dengan tepat.\n\nSaat menggunakan internet, pengguna perlu menjaga keamanan data dan perangkat. Pengguna perlu memperhatikan koneksi yang aman, berhati-hati terhadap tautan mencurigakan, serta melindungi informasi pribadi ketika berkomunikasi online.",
                'video_url' => '',
            ],
            [
                'bab' => 'Bab 7',
                'judul' => 'Pemanfaatan Media Sosial',
                'deskripsi' => "Media sosial dapat digunakan untuk berkomunikasi, berbagi informasi, membuat konten, dan berkolaborasi. Siswa perlu memahami manfaat media sosial sekaligus dampaknya terhadap kehidupan pribadi dan masyarakat.\n\nEtika bermedia sosial diperlukan agar interaksi digital tetap sehat. Pengguna perlu memakai bahasa yang baik, menghargai orang lain, tidak menyebarkan informasi negatif, dan berpikir sebelum mengunggah sesuatu.\n\nKonten digital yang baik perlu memiliki tujuan, pesan yang jelas, dan bentuk yang sesuai dengan audiens. Dalam membuat konten, siswa perlu merancang ide, memilih media, menyusun informasi, serta memperhatikan keaslian dan manfaat konten.\n\nKarya digital perlu dihargai karena memiliki hak cipta. Selain itu, aktivitas di internet dapat meninggalkan jejak digital. Jejak digital dapat memengaruhi citra diri dan keamanan pengguna di masa depan, sehingga perlu dijaga dengan baik.",
                'video_url' => '',
            ],
            [
                'bab' => 'Bab 8',
                'judul' => 'Perlindungan Data dari Kejahatan Digital',
                'deskripsi' => "Data pribadi seperti nama, alamat, nomor telepon, email, kata sandi, dan data akun perlu dijaga. Data pribadi dapat disalahgunakan jika dibagikan sembarangan di internet.\n\nKata sandi yang kuat membantu melindungi akun dari akses tidak sah. Kata sandi sebaiknya tidak mudah ditebak, tidak memakai data pribadi, dan diganti apabila dicurigai sudah diketahui orang lain.\n\nAutentikasi dua langkah menambah lapisan keamanan saat masuk ke akun digital. Dengan fitur ini, pengguna tidak hanya memakai kata sandi, tetapi juga kode atau konfirmasi tambahan dari perangkat lain.\n\nKejahatan digital dapat berupa phishing, penipuan online, pencurian akun, dan penyalahgunaan data. Siswa perlu mengenali tanda-tanda ancaman digital dan mengambil langkah pencegahan yang tepat, seperti tidak membuka tautan mencurigakan dan mengatur privasi akun.",
                'video_url' => '',
            ],
        ];

        foreach ($data as $materi) {
            Materi::create($materi);
        }
    }
}
