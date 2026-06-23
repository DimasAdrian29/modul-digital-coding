.certificate-fixed-page {
    position: relative;
    width: 297mm;
    height: 210mm;
    max-width: 297mm;
    max-height: 210mm;
    overflow: hidden;
    background: #ffffff;
    color: #102a43;
    font-family: "Inter", "DejaVu Sans", Arial, sans-serif;
    page-break-before: avoid;
    page-break-after: avoid;
    page-break-inside: avoid;
    break-before: avoid;
    break-after: avoid;
    break-inside: avoid;
}

.certificate-fixed-outer {
    position: absolute;
    left: 38px;
    top: 34px;
    width: 1047px;
    height: 726px;
    border: 2px solid #a9c6ff;
}

.certificate-fixed-inner {
    position: absolute;
    left: 62px;
    top: 58px;
    width: 999px;
    height: 678px;
    border: 1px solid #d8e6ff;
}

.certificate-fixed-ribbon-bg {
    position: absolute;
    right: 38px;
    top: 34px;
    width: 180px;
    height: 92px;
    background: #16459c;
}

.certificate-fixed-ribbon {
    position: absolute;
    right: 78px;
    top: 66px;
    color: #ffffff;
    font-size: 15px;
    line-height: 1;
    font-weight: 900;
    letter-spacing: 2px;
}

.certificate-fixed-logo {
    position: absolute;
    left: 92px;
    top: 76px;
    width: 68px;
    height: 68px;
    border-radius: 16px;
    background: #2864ff;
    color: #ffffff;
    text-align: center;
    line-height: 68px;
    font-size: 22px;
    font-weight: 900;
}

.certificate-fixed-brand {
    position: absolute;
    left: 184px;
    top: 94px;
}

.certificate-fixed-brand strong {
    display: block;
    color: #0f2a5f;
    font-size: 18px;
    line-height: 1.2;
    letter-spacing: 0.4px;
}

.certificate-fixed-brand span,
.certificate-fixed-number span,
.certificate-fixed-meta span,
.certificate-fixed-signature span {
    display: block;
    color: #4d6690;
    font-size: 13px;
    line-height: 1.2;
}

.certificate-fixed-brand span {
    margin-top: 14px;
}

.certificate-fixed-number {
    position: absolute;
    top: 92px;
    right: 254px;
    width: 270px;
    text-align: right;
}

.certificate-fixed-number strong {
    display: block;
    margin-top: 12px;
    color: #0f2a5f;
    font-size: 17px;
    line-height: 1.1;
    font-weight: 900;
    letter-spacing: 1px;
}

.certificate-fixed-title {
    position: absolute;
    top: 244px;
    left: 0;
    width: 1123px;
    color: #1e63ff;
    text-align: center;
    font-size: 15px;
    line-height: 1;
    font-weight: 900;
    letter-spacing: 4px;
}

.certificate-fixed-given {
    position: absolute;
    top: 314px;
    left: 0;
    width: 1123px;
    color: #4d6690;
    text-align: center;
    font-size: 18px;
    line-height: 1;
}

.certificate-fixed-name {
    position: absolute;
    top: 358px;
    left: 126px;
    width: 870px;
    color: #0f2a5f;
    text-align: center;
    font-size: 56px;
    line-height: 1;
    font-weight: 900;
    letter-spacing: 0;
}

.certificate-fixed-statement {
    position: absolute;
    top: 458px;
    left: 165px;
    width: 793px;
    color: #2f4b74;
    text-align: center;
    font-size: 17px;
    line-height: 1.55;
}

.certificate-fixed-meta {
    position: absolute;
    top: 568px;
    width: 154px;
    height: 72px;
    padding: 17px 16px;
    border: 1px solid #d1e0ff;
    background: #f8fbff;
}

.certificate-fixed-meta strong {
    display: block;
    margin-top: 12px;
    color: #0f2a5f;
    font-size: 16px;
    line-height: 1.05;
    font-weight: 800;
}

.meta-nis {
    left: 92px;
}

.meta-kelas {
    left: 268px;
}

.meta-jurusan {
    left: 444px;
}

.meta-tanggal {
    left: 620px;
}

.certificate-fixed-signature {
    position: absolute;
    right: 90px;
    bottom: 70px;
    width: 190px;
    text-align: center;
}

.certificate-fixed-signature div {
    width: 170px;
    height: 2px;
    margin: 60px auto 14px;
    background: #0f2a5f;
}

.certificate-fixed-signature strong {
    color: #0f2a5f;
    font-size: 15px;
    line-height: 1.1;
    font-weight: 900;
}

@media (max-width: 1180px) {
    .certificate-pages {
        overflow-x: auto;
    }

    .certificate-fixed-page {
        transform: scale(0.82);
        transform-origin: top left;
        margin-bottom: -140px;
    }
}

@media (max-width: 720px) {
    .certificate-fixed-page {
        transform: scale(0.48);
        margin-bottom: -390px;
    }
}
