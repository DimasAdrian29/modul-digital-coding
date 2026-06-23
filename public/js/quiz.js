document.addEventListener('DOMContentLoaded', () => {
    const quizApp = document.getElementById('quizApp');

    if (!quizApp) {
        return;
    }

    const questions = [...quizApp.querySelectorAll('[data-question]')];
    const currentQuestionLabel = document.getElementById('currentQuestion');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const finishBtn = document.getElementById('finishBtn');
    const resultCard = document.getElementById('resultCard');
    const scoreValue = document.getElementById('scoreValue');
    const scoreDescription = document.getElementById('scoreDescription');
    const completionMessage = document.getElementById('completionMessage');
    const reviewList = document.getElementById('reviewList');
    const certificateCard = document.getElementById('certificateCard');
    const certificateName = document.getElementById('certificateName');
    const certificateScore = document.getElementById('certificateScore');
    const certificateStatus = document.getElementById('certificateStatus');
    const certificateDate = document.getElementById('certificateDate');
    const certificateActions = document.getElementById('certificateActions');
    const viewCertificateBtn = document.getElementById('viewCertificateBtn');
    const downloadCertificateBtn = document.getElementById('downloadCertificateBtn');
    const answers = new Array(questions.length).fill(null);
    const passingScore = Math.ceil(questions.length * 0.8);
    let currentIndex = 0;
    let isFinished = false;

    const previousAttempt = (() => {
        if (!quizApp.dataset.previousAttempt || quizApp.dataset.previousAttempt === 'null') {
            return null;
        }

        try {
            return JSON.parse(quizApp.dataset.previousAttempt);
        } catch (error) {
            return null;
        }
    })();

    const markBabComplete = async () => {
        const completeUrl = quizApp.dataset.completeUrl;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        if (!completeUrl || !csrfToken) {
            return;
        }

        try {
            const response = await fetch(completeUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ completed: true }),
            });

            if (!response.ok) {
                return;
            }

            const result = await response.json();

            if (completionMessage) {
                completionMessage.textContent = result.message ?? 'Bab selesai. Bab berikutnya sudah terbuka.';
                completionMessage.style.color = '#166534';
                completionMessage.style.fontWeight = '700';
            }
        } catch (error) {
            if (completionMessage) {
                completionMessage.textContent = 'Nilai sudah memenuhi syarat, tetapi status selesai belum tersimpan. Muat ulang lalu coba tekan selesai lagi.';
                completionMessage.style.color = '#991b1b';
                completionMessage.style.fontWeight = '700';
            }
        }
    };

    const saveBabAttempt = async (score) => {
        const attemptUrl = quizApp.dataset.attemptUrl;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        if (!attemptUrl || !csrfToken) {
            return null;
        }

        try {
            const response = await fetch(attemptUrl, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    answers,
                    score,
                }),
            });

            if (!response.ok) {
                return null;
            }

            return await response.json();
        } catch (error) {
            return null;
        }
    };

    const updateView = () => {
        questions.forEach((question, index) => {
            question.classList.toggle('active', index === currentIndex);
        });

        currentQuestionLabel.textContent = String(currentIndex + 1);
        prevBtn.classList.toggle('hidden', currentIndex === 0);
        nextBtn.classList.toggle('hidden', currentIndex === questions.length - 1);
        finishBtn.classList.toggle('hidden', isFinished || currentIndex !== questions.length - 1);
    };

    const lockAnswers = () => {
        questions.forEach((question, index) => {
            const selectedAnswer = answers[index];
            const correctAnswer = question.dataset.answer;

            question.querySelectorAll('[data-option]').forEach((button) => {
                button.disabled = true;

                if (button.dataset.option === correctAnswer) {
                    button.classList.add('correct');
                }

                if (selectedAnswer === button.dataset.option && selectedAnswer !== correctAnswer) {
                    button.classList.add('incorrect');
                }
            });
        });
    };

    const showCertificate = (score, dateLabel = null) => {
        if (!certificateCard) {
            return;
        }

        const babName = quizApp.dataset.babName ?? 'Latihan Coding';
        const passed = score >= passingScore;
        const date = dateLabel ?? new Date().toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });

        if (certificateName) {
            certificateName.textContent = babName;
        }

        if (certificateScore) {
            certificateScore.textContent = `${score} / ${questions.length}`;
        }

        if (certificateStatus) {
            certificateStatus.textContent = passed
                ? 'Memenuhi nilai minimal 80%'
                : `Belum lulus, minimal benar ${passingScore} soal`;
        }

        if (certificateDate) {
            certificateDate.textContent = date;
        }

        if (passed && quizApp.dataset.certificateShowUrl && quizApp.dataset.certificateDownloadUrl) {
            if (viewCertificateBtn) {
                viewCertificateBtn.href = quizApp.dataset.certificateShowUrl;
            }

            if (downloadCertificateBtn) {
                downloadCertificateBtn.href = quizApp.dataset.certificateDownloadUrl;
            }

            certificateActions?.classList.remove('hidden');
        } else {
            certificateActions?.classList.add('hidden');
        }

        certificateCard.classList.toggle('passed', passed);
        certificateCard.classList.toggle('retry', !passed);
        certificateCard.classList.remove('hidden');
    };

    const renderReview = () => {
        if (!reviewList) {
            return;
        }

        reviewList.innerHTML = questions.map((question, index) => {
            const userAnswer = answers[index] ?? '-';
            const correctAnswer = question.dataset.answer;
            const statusClass = userAnswer === correctAnswer ? 'correct' : 'incorrect';
            const statusText = userAnswer === correctAnswer ? 'Benar' : 'Belum tepat';

            return `
                <article class="review-item ${statusClass}">
                    <h4>Soal ${index + 1}</h4>
                    <p>${question.querySelector('.question-head h3')?.textContent ?? ''}</p>
                    <p>Jawaban Anda: <strong>${userAnswer}</strong></p>
                    <p>Kunci Jawaban: <strong>${correctAnswer}</strong></p>
                    <span class="review-status">${statusText}</span>
                </article>
            `;
        }).join('');
    };

    const showResult = (score, dateLabel = null) => {
        scoreValue.textContent = `${score} / ${questions.length}`;
        showCertificate(score, dateLabel);

        if (score >= passingScore) {
            scoreDescription.textContent = score === questions.length
                ? 'Nilai sempurna. Pemahaman Anda sangat baik.'
                : 'Nilai sudah memenuhi syarat. Bab berikutnya dapat dibuka.';
        } else if (score >= Math.ceil(questions.length * 0.7)) {
            scoreDescription.textContent = 'Hasilnya bagus. Tinggal sedikit lagi untuk nilai maksimal.';
        } else {
            scoreDescription.textContent = 'Tetap semangat. Pelajari kembali materi lalu coba lagi.';
        }

        renderReview();
        resultCard.classList.remove('hidden');
    };

    const restorePreviousAttempt = () => {
        if (!previousAttempt || Number(previousAttempt.total) !== questions.length) {
            return false;
        }

        const savedAnswers = Array.isArray(previousAttempt.answers) ? previousAttempt.answers : [];

        savedAnswers.forEach((answer, index) => {
            answers[index] = answer;
            const selectedButton = questions[index]?.querySelector(`[data-option="${answer}"]`);

            if (selectedButton) {
                selectedButton.classList.add('selected');
                const feedback = questions[index].querySelector('[data-feedback]');

                if (feedback) {
                    feedback.textContent = `Jawaban dipilih: ${answer}`;
                    feedback.style.color = '#1e63ff';
                }
            }
        });

        isFinished = true;
        lockAnswers();
        updateView();
        showResult(Number(previousAttempt.score), previousAttempt.completed_at_label);

        if (completionMessage) {
            completionMessage.textContent = previousAttempt.passed
                ? 'Latihan ini sudah selesai. Bab berikutnya sudah terbuka.'
                : `Latihan ini sudah selesai, tetapi belum lulus. Minimal benar ${passingScore} dari ${questions.length} soal.`;
            completionMessage.style.color = previousAttempt.passed ? '#166534' : '#991b1b';
            completionMessage.style.fontWeight = '700';
        }

        return true;
    };

    questions.forEach((question, index) => {
        const buttons = [...question.querySelectorAll('[data-option]')];
        const feedback = question.querySelector('[data-feedback]');
        const correctAnswer = question.dataset.answer;

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                if (isFinished) {
                    return;
                }

                answers[index] = button.dataset.option;

                buttons.forEach((item) => {
                    item.classList.remove('selected');
                });

                button.classList.add('selected');
                feedback.textContent = `Jawaban dipilih: ${button.dataset.option}`;
                feedback.style.color = '#1e63ff';
            });
        });
    });

    prevBtn?.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex -= 1;
            updateView();
        }
    });

    nextBtn?.addEventListener('click', () => {
        if (currentIndex < questions.length - 1) {
            currentIndex += 1;
            updateView();
        }
    });

    finishBtn?.addEventListener('click', async () => {
        if (isFinished) {
            return;
        }

        const score = answers.reduce((total, answer, index) => {
            return total + (answer === questions[index].dataset.answer ? 1 : 0);
        }, 0);

        isFinished = true;
        lockAnswers();
        updateView();
        showResult(score);

        const savedAttempt = await saveBabAttempt(score);

        if (savedAttempt?.certificate?.show_url && savedAttempt?.certificate?.download_url) {
            quizApp.dataset.certificateShowUrl = savedAttempt.certificate.show_url;
            quizApp.dataset.certificateDownloadUrl = savedAttempt.certificate.download_url;
        }

        if (savedAttempt?.attempt?.completed_at_label) {
            showCertificate(score, savedAttempt.attempt.completed_at_label);
        }

        if (score >= passingScore) {
            if (completionMessage) {
                completionMessage.textContent = 'Menyimpan status bab selesai...';
                completionMessage.style.color = '#075985';
                completionMessage.style.fontWeight = '700';
            }
            await markBabComplete();
        } else if (score >= Math.ceil(questions.length * 0.7)) {
            if (completionMessage) {
                completionMessage.textContent = `Bab berikutnya masih terkunci. Minimal benar ${passingScore} dari ${questions.length} soal.`;
                completionMessage.style.color = '#991b1b';
                completionMessage.style.fontWeight = '700';
            }
        } else {
            if (completionMessage) {
                completionMessage.textContent = `Bab berikutnya masih terkunci. Minimal benar ${passingScore} dari ${questions.length} soal.`;
                completionMessage.style.color = '#991b1b';
                completionMessage.style.fontWeight = '700';
            }
        }

        resultCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    if (!restorePreviousAttempt()) {
        updateView();
    }
});
