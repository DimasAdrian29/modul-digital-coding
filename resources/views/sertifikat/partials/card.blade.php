<article class="certificate-fixed-page">
    <div class="certificate-fixed-outer"></div>
    <div class="certificate-fixed-inner"></div>

    <div class="certificate-fixed-ribbon-bg"></div>
    <div class="certificate-fixed-ribbon">LULUS</div>

    <div class="certificate-fixed-logo">MD</div>

    <div class="certificate-fixed-brand">
        <strong>{{ $sertifikat->nama_sekolah }}</strong>
        <span>Modul Digital Informatika</span>
    </div>

    <div class="certificate-fixed-number">
        <span>Nomor Sertifikat</span>
        <strong>{{ $sertifikat->nomor_sertifikat }}</strong>
    </div>

    <div class="certificate-fixed-title">SERTIFIKAT KOMPETENSI KELULUSAN</div>
    <div class="certificate-fixed-given">Diberikan kepada</div>
    <div class="certificate-fixed-name">{{ $sertifikat->nama_siswa }}</div>
    <div class="certificate-fixed-statement">
        Atas keberhasilannya menyelesaikan latihan <strong>{{ $sertifikat->nama_materi }}</strong>
        dengan nilai akhir <strong>{{ number_format((float) $sertifikat->nilai_akhir, 2) }}%</strong>.
    </div>

    <div class="certificate-fixed-meta meta-nis">
        <span>NIS/NISN</span>
        <strong>{{ $sertifikat->nis_nisn ?? '-' }}</strong>
    </div>
    <div class="certificate-fixed-meta meta-kelas">
        <span>Kelas</span>
        <strong>{{ $sertifikat->kelas ?? '-' }}</strong>
    </div>
    <div class="certificate-fixed-meta meta-jurusan">
        <span>Jurusan</span>
        <strong>{{ $sertifikat->jurusan ?? '-' }}</strong>
    </div>
    <div class="certificate-fixed-meta meta-tanggal">
        <span>Tanggal</span>
        <strong>{{ $sertifikat->tanggal_selesai->translatedFormat('d F Y') }}</strong>
    </div>

    <div class="certificate-fixed-signature">
        <span>Guru</span>
        <div></div>
        <strong>{{ $sertifikat->ditandatangani_oleh ?? 'Guru' }}</strong>
    </div>
</article>
