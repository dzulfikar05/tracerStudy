<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            [
                'type' => 'carousel',
                'title' => 'Gambar Carousel 1',
                'text' => null,
                'image' => '1748700087.png',
                'order' => 1,
            ],
            [
                'type' => 'carousel',
                'title' => 'Carousel 2',
                'text' => null,
                'image' => '1748699994.png',
                'order' => 2,
            ],
            [
                'type' => 'carousel',
                'title' => 'Carousel 3',
                'text' => null,
                'image' => '1748700016.png',
                'order' => 3,
            ],
            [
                'type' => 'carousel',
                'title' => 'Carousel 4',
                'text' => null,
                'image' => '1748699261.png',
                'order' => 4,
            ],
            [
                'type' => 'home',
                'title' => 'TENTANG TRACER STUDY',
                'text' => '<h3><span style="font-size:24px"><strong>Apa itu<span style="color:#1a3c8f"> Tracer Study </span>?</strong></span>&nbsp;</h3><p><span style="font-size:14px">Tracer Study merupakan salah satu metode yang digunakan oleh perguruan tinggi untuk memperoleh umpan balik dari alumni. Umpan balik yang diperoleh dari alumni ini dibutuhkan untuk perbaikan serta pengembangan kualitas dan sistem pendidikan. </span></p>',
                'image' => '1748702184.png',
                'order' => 5,
            ],
            [
                'type' => 'about',
                'title' => 'Keterangan',
                'text' => '<p>Tracer Study adalah studi suvei yang berujuan untuk melacak jejak alumni dan mengumpulkan data mengenai status kerja, relevansi pekerjaan, dan tingkat pendapatan mereka.</p><p>Data ini kemudian digunakan untuk meningkatkan kualitas pendidikan dan kurikulum di Polinema, serta menjalin hubungan antara alumni dengan program studi.</p>',
                'image' => null,
                'order' => 6,
            ],
            [
                'type' => 'about',
                'title' => 'Tujuan Tracer Study',
                'text' => '<h3><span style="font-size:18px"><strong>Tujuan Tracer Studi</strong></span></h3><p><span style="font-size:14px">Tracer Studi memiliki beberapa tujuan penting, di antaranya:</span></p><ul><li><span style="font-size:14px">Mengevaluasi output/outcome pendidikan tinggi</span></li><li><span style="font-size:14px">Memperoleh informasi penting untuk pengembangan institusi</span></li><li><span style="font-size:14px">Mengetahui relevansi kurikulum dengan kebutuhan dunia kerja</span></li><li><span style="font-size:14px">Sebagai kontribusi untuk akreditasi program studi</span></li><li><span style="font-size:14px">Memberikan informasi kepada mahasiswa, orang tua, dosen, administrasi pendidikan dan para pelaku pendidikan mengenai transisi dari dunia pendidikan tinggi ke dunia kerja</span></li></ul>',
                'image' => null,
                'order' => 7,
            ],
            [
                'type' => 'about',
                'title' => 'Manfaat',
                'text' => '<h3><strong><span style="font-size:18px">Manfaat Tracer Studi</span></strong></h3><p><span style="font-size:14px">Hasil dari Tracer Studi dapat digunakan sebagai bahan pertimbangan dalam pengembangan kurikulum, peningkatan kualitas pembelajaran, dan penguatan jaringan alumni. Dengan adanya data yang akurat tentang kondisi alumni di dunia kerja, institusi pendidikan dapat melakukan perbaikan dan inovasi yang relevan dengan kebutuhan pasar.</span></p><p><span style="font-size:14px">Selain itu, Tracer Studi juga bermanfaat bagi para alumni untuk tetap terhubung dengan almamater dan membuka peluang kolaborasi di masa depan.</span></p>',
                'image' => null,
                'order' => 8,
            ],
            [
                'type' => 'about',
                'title' => 'Metodelogi',
                'text' => '<h3><span style="font-size:18px"><strong>Metodologi Tracer Studi</strong></span></h3><p><span style="font-size:14px">Tracer Studi dilakukan dengan metode survei terhadap alumni yang telah lulus dalam kurun waktu tertentu. Survei ini mencakup berbagai aspek, seperti:</span></p><ul><li><span style="font-size:14px">Proses pencarian kerja</span></li><li><span style="font-size:14px">Situasi kerja saat ini</span></li><li><span style="font-size:14px">Penerapan kompetensi di dunia kerja</span></li><li><span style="font-size:14px">Evaluasi terhadap proses pembelajaran</span></li><li><span style="font-size:14px">Saran untuk pengembangan institusi</span></li></ul><p><span style="font-size:14px">Data yang diperoleh kemudian dianalisis untuk mendapatkan gambaran mengenai kondisi alumni dan relevansi pendidikan dengan kebutuhan dunia kerja.</span></p>',
                'image' => null,
                'order' => 9,
            ],
            [
                'type' => 'about',
                'title' => 'Implementasi',
                'text' => '<h3><span style="font-size:18px"><strong>Implementasi Hasil Tracer Studi</strong></span></h3><p><span style="font-size:14px">Hasil dari Tracer Studi tidak hanya berhenti pada tahap analisis data, tetapi juga diimplementasikan dalam berbagai kebijakan dan program, seperti:</span></p><ul><li><span style="font-size:14px">Revisi kurikulum</span></li><li><span style="font-size:14px">Pengembangan program studi baru</span></li><li><span style="font-size:14px">Peningkatan kualitas pembelajaran</span></li><li><span style="font-size:14px">Penguatan jaringan alumni</span></li><li><span style="font-size:14px">Pengembangan kerjasama dengan industri</span></li></ul><p><span style="font-size:14px">Dengan demikian, Tracer Studi menjadi instrumen penting dalam upaya peningkatan kualitas pendidikan dan relevansinya dengan kebutuhan dunia kerja.</span></p>',
                'image' => null,
                'order' => 10,
            ],
            [
                'type' => 'home',
                'title' => 'MANFAAT TRACER STUDY',
                'text' => '<h3><span style="font-size:24px"><strong>Manfaat <span style="color:#1a3c8f">Tracer Study</span></strong></span></h3><p><span style="font-size:14px">Fokus tracer study (TS) yang dilakukan adalah untuk menelusuri alumni yang sudah bekerja atau berwirausaha. Manfaat yang didapat di bumi kerja sebagai bidang pekerjaan, dan dari pertama, hasil TS diharapkan dapat membantu perguruan tinggi untuk mengetahui keberhasilan proses pendidikan yang telah dilakukan terhadap anak didiknya. Kedua, membantu perguruan tinggi dalam melakukan need assessment survey pada external stakeholder untuk meminta secara spesifik tentang skill, kompetensi, dan pengetahuan apa saja yang diperlukan oleh dunia kerja. Ketiga, membantu perguruan tinggi dalam mengetahui relevansi kurikulum yang sudah diterapkan di perguruan tinggi dengan kebutuhan pasar tenaga kerja dan pengembangan profesional.</span></p>',
                'image' => '1748784423.png',
                'order' => 11,
            ],
            [
                'type' => 'home',
                'title' => 'TUJUAN TRACER STUDY',
                'text' => '<h3><span style="font-size:24px"><strong><span style="color:#1a3c8f">Tracer Study</span> ditujukan untuk :</strong></span></h3><ul><li><span style="font-size:18px"><span style="color:#1a3c8f"><strong>Jaminan Kualitas</strong></span></span></li><li><span style="font-size:18px"><span style="color:#1a3c8f"><strong>Akreditasi</strong></span></span><p><span style="font-size:18px">Mendukung pengajuan tinggi dalam proses akreditasi, baik nasional maupun internasional.</span></p></li><li><p><span style="font-size:18px"><span style="color:#1a3c8f"><strong>Informasi Lulusan</strong></span></span></p></li></ul>',
                'image' => '1748784633.png',
                'order' => 12,
            ],
        ];

        foreach ($contents as $content) {
            $sourcePath = public_path('img/' . $content['image']);
            $destinationPath = 'content/' . $content['image'];

            if (file_exists($sourcePath) && !Storage::disk('public')->exists($destinationPath)) {
                Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
            }

            Content::create($content);
        }
    }
}
