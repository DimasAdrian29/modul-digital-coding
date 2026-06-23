<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        html,
        body {
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #ffffff;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
            break-before: avoid;
            break-after: avoid;
            break-inside: avoid;
        }

        @include('sertifikat.partials.fixed-style')

        .certificate-fixed-page {
            transform: none !important;
            margin: 0 !important;
            width: 297mm !important;
            height: 210mm !important;
            page-break-before: avoid !important;
            page-break-after: avoid !important;
            page-break-inside: avoid !important;
            break-before: avoid !important;
            break-after: avoid !important;
            break-inside: avoid !important;
        }
    </style>
</head>
<body>
    @include('sertifikat.partials.card', ['sertifikat' => $sertifikat, 'detail' => $detail])
</body>
</html>
