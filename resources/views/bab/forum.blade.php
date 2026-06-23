@extends('layouts.app')

@section('title', 'Forum Diskusi ' . $babName)

@section('content')
    <section class="page-header student-page-header forum-page-header">
        <span class="eyebrow">Forum Diskusi</span>
        <h1>{{ $babName }}</h1>
        <p>Ruang diskusi untuk tanya jawab dan berbagi pemahaman pada bab ini.</p>
        <div class="page-header-actions">
            <a href="{{ route('home') }}" class="secondary-button">Kembali ke Daftar Bab</a>
        </div>
    </section>

    <section class="section-block">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Topik Forum</span>
                <h2>Diskusi yang dapat diikuti siswa</h2>
            </div>
            <a href="{{ route('bab.show', $babSlug) }}" class="text-link">Kembali ke ruang bab</a>
        </div>

        <div class="forum-grid">
            @foreach ($forumTopics as $topic)
                <article class="forum-card">
                    <span class="choice-icon">{{ $loop->iteration }}</span>
                    <h3>{{ $topic['judul'] }}</h3>
                    <p>{{ $topic['isi'] }}</p>
                    <span class="forum-meta">Diskusi bab {{ $babName }}</span>
                </article>
            @endforeach
        </div>
    </section>

    <section class="section-block">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Kirim Diskusi</span>
                <h2>Tulis pertanyaan atau pendapatmu</h2>
            </div>
        </div>

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert danger">
                <strong>Diskusi belum bisa dikirim.</strong>
                <p>Periksa kembali nama, judul, dan isi diskusi.</p>
            </div>
        @endif

        <form action="{{ route('bab.forum.store', $babSlug) }}" method="POST" class="forum-form">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama') }}"
                        placeholder="Contoh: Ahmad"
                        required>
                    @error('nama')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="judul">Judul diskusi</label>
                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        value="{{ old('judul') }}"
                        placeholder="Contoh: Masih bingung bagian latihan"
                        required>
                    @error('judul')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="isi">Isi diskusi</label>
                <textarea
                    id="isi"
                    name="isi"
                    rows="5"
                    placeholder="Tulis pertanyaan, ide, atau pengalaman belajarmu di bab ini."
                    required>{{ old('isi') }}</textarea>
                @error('isi')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="primary-button">Kirim diskusi</button>
        </form>
    </section>

    <section class="section-block">
        <div class="section-heading">
            <div>
                <span class="eyebrow">Diskusi Siswa</span>
                <h2>Postingan pada {{ $babName }}</h2>
            </div>
        </div>

        <div class="forum-post-list">
            @forelse ($posts as $post)
                <article class="forum-post-card">
                    <div class="forum-post-head">
                        <div>
                            <h3>{{ $post->judul }}</h3>
                            <span class="forum-meta">Oleh {{ $post->nama }} - {{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <p>{{ $post->isi }}</p>

                    @if ($post->guru_balasan)
                        <div class="forum-admin-reply">
                            <strong>Balasan Guru</strong>
                            @if ($post->guru_dibalas_pada)
                                <span class="forum-meta">{{ $post->guru_dibalas_pada->diffForHumans() }}</span>
                            @endif
                            <p>{{ $post->guru_balasan }}</p>
                        </div>
                    @endif

                    <div class="forum-replies">
                        <div class="forum-replies-head">
                            <strong>Balasan Siswa</strong>
                            <span class="forum-meta">{{ $post->replies->count() }} balasan</span>
                        </div>

                        @forelse ($post->replies as $reply)
                            <article class="forum-reply-card">
                                <div class="forum-reply-meta">
                                    <strong>{{ $reply->nama }}</strong>
                                    <span>{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p>{{ $reply->isi }}</p>
                            </article>
                        @empty
                            <p class="forum-empty-reply">Belum ada balasan dari siswa lain.</p>
                        @endforelse
                    </div>

                    <form action="{{ route('bab.forum.reply.store', [$babSlug, $post]) }}" method="POST" class="forum-reply-form">
                        @csrf
                        <div class="form-group">
                            <label for="reply-{{ $post->id }}">Balas diskusi ini</label>
                            <textarea
                                id="reply-{{ $post->id }}"
                                name="isi"
                                rows="3"
                                placeholder="Tulis tanggapan atau bantu jawab pertanyaan temanmu."
                                required>{{ old('isi') }}</textarea>
                        </div>
                        <button type="submit" class="secondary-button">Kirim Balasan</button>
                    </form>
                </article>
            @empty
                <div class="empty-state">
                    <h3>Belum ada diskusi</h3>
                    <p>Jadilah yang pertama mengirim pertanyaan atau pendapat pada bab ini.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection

