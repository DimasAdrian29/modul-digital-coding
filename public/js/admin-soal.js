document.addEventListener('DOMContentLoaded', () => {
    const addButton = document.getElementById('addQuestionBtn');
    const list = document.getElementById('questionFormList');
    const template = document.getElementById('questionRowTemplate');

    if (!addButton || !list || !template) {
        return;
    }

    const fieldLabels = {
        bab: 'Bab',
        pertanyaan: 'Pertanyaan',
        pilihan_a: 'Pilihan A',
        pilihan_b: 'Pilihan B',
        pilihan_c: 'Pilihan C',
        pilihan_d: 'Pilihan D',
        jawaban_benar: 'Jawaban Benar',
    };

    const rows = () => [...list.querySelectorAll('[data-question-row]')];

    const refreshRows = () => {
        rows().forEach((row, index) => {
            row.querySelector('[data-question-number]').textContent = String(index + 1);

            row.querySelectorAll('[data-field]').forEach((field) => {
                const key = field.dataset.field;
                const id = `questions_${index}_${key}`;

                field.id = id;
                field.name = `questions[${index}][${key}]`;
            });

            row.querySelectorAll('[data-field-label]').forEach((label) => {
                const key = label.dataset.fieldLabel;
                label.htmlFor = `questions_${index}_${key}`;
                label.textContent = fieldLabels[key] ?? key;
            });

            const removeButton = row.querySelector('[data-remove-question]');
            removeButton.disabled = rows().length === 1;
        });
    };

    const addRow = () => {
        const fragment = template.content.cloneNode(true);
        list.appendChild(fragment);
        refreshRows();
    };

    list.addEventListener('click', (event) => {
        const removeButton = event.target.closest('[data-remove-question]');

        if (!removeButton || rows().length === 1) {
            return;
        }

        removeButton.closest('[data-question-row]').remove();
        refreshRows();
    });

    addButton.addEventListener('click', addRow);

    refreshRows();
});
