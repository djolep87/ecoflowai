<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EL-1 - Evidencioni list otpada - {{ $evidenceSheet->godina }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            line-height: 1.6;
            background: #ffffff;
            padding: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #1a1a1a;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header h2 {
            font-size: 16px;
            font-weight: normal;
            color: #333;
        }
        .company-info {
            background: #f8f9fa;
            border: 2px solid #1a1a1a;
            padding: 25px;
            margin-bottom: 30px;
        }
        .company-info-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
            border-bottom: 2px solid #1a1a1a;
            padding-bottom: 8px;
        }
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }
        .info-label {
            display: table-cell;
            width: 150px;
            font-weight: bold;
            vertical-align: top;
        }
        .info-value {
            display: table-cell;
            vertical-align: top;
        }
        .waste-info {
            border: 2px solid #1a1a1a;
            padding: 25px;
            margin-bottom: 30px;
        }
        .waste-info-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
            border-bottom: 2px solid #1a1a1a;
            padding-bottom: 8px;
        }
        .waste-details {
            margin-top: 20px;
        }
        .waste-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .waste-details table td {
            padding: 10px;
            border: 1px solid #1a1a1a;
        }
        .waste-details table td:first-child {
            font-weight: bold;
            width: 200px;
            background: #f8f9fa;
        }
        .quantity-highlight {
            font-size: 16px;
            font-weight: bold;
            color: #1a1a1a;
        }
        .description {
            border: 2px solid #1a1a1a;
            padding: 20px;
            margin-bottom: 30px;
            min-height: 100px;
        }
        .description-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .description-text {
            font-size: 12px;
            line-height: 1.8;
        }
        .signature-section {
            margin-top: 60px;
            border-top: 2px solid #1a1a1a;
            padding-top: 30px;
        }
        .signature-block {
            display: inline-block;
            width: 45%;
            margin-right: 5%;
            vertical-align: top;
        }
        .signature-block:last-child {
            margin-right: 0;
        }
        .signature-title {
            font-weight: bold;
            margin-bottom: 80px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .signature-line {
            border-top: 2px solid #1a1a1a;
            margin-top: 5px;
            padding-top: 5px;
            font-size: 10px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .year-badge {
            display: inline-block;
            background: #1a1a1a;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            font-weight: bold;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>EVIDENCIONI LIST OTPADA</h1>
        <h2>EL-1 obrazac</h2>
        <div style="margin-top: 15px;">
            <span>Godina: <span class="year-badge">{{ $evidenceSheet->godina }}</span></span>
        </div>
    </div>

    <!-- Company Information -->
    <div class="company-info">
        <div class="company-info-title">Podaci o firmi</div>
        <div class="info-row">
            <div class="info-label">Naziv firme:</div>
            <div class="info-value">{{ $evidenceSheet->company->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">PIB:</div>
            <div class="info-value">{{ $evidenceSheet->company->pib }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Adresa:</div>
            <div class="info-value">{{ $evidenceSheet->company->adresa }}</div>
        </div>
        @if($evidenceSheet->company->maticni_broj)
        <div class="info-row">
            <div class="info-label">Matični broj:</div>
            <div class="info-value">{{ $evidenceSheet->company->maticni_broj }}</div>
        </div>
        @endif
        @if($evidenceSheet->company->telefon)
        <div class="info-row">
            <div class="info-label">Telefon:</div>
            <div class="info-value">{{ $evidenceSheet->company->telefon }}</div>
        </div>
        @endif
        @if($evidenceSheet->company->email)
        <div class="info-row">
            <div class="info-label">Email:</div>
            <div class="info-value">{{ $evidenceSheet->company->email }}</div>
        </div>
        @endif
    </div>

    <!-- Waste Information -->
    <div class="waste-info">
        <div class="waste-info-title">Podaci o otpadu</div>
        <div class="waste-details">
            <table>
                <tr>
                    <td>Vrsta otpada:</td>
                    <td><strong>{{ $evidenceSheet->waste_type }}</strong></td>
                </tr>
                <tr>
                    <td>Godina:</td>
                    <td><strong>{{ $evidenceSheet->godina }}</strong></td>
                </tr>
                <tr>
                    <td>Ukupna količina po godini:</td>
                    <td class="quantity-highlight">
                        {{ number_format($evidenceSheet->ukupna_kolicina, 2, ',', '.') }} {{ $evidenceSheet->jedinica_mere }}
                    </td>
                </tr>
                <tr>
                    <td>Jedinica mere:</td>
                    <td>{{ $evidenceSheet->jedinica_mere }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Description/Notes -->
    <div class="description">
        <div class="description-title">Opis / Napomena</div>
        <div class="description-text">
            @if($evidenceSheet->opis)
                {{ $evidenceSheet->opis }}
            @else
                <em>Nema dodatnih napomena.</em>
            @endif
        </div>
    </div>

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-block">
            <div class="signature-title">Mesto za potpis</div>
            <div class="signature-line">
                <div style="margin-top: 5px; font-size: 11px;">
                    <strong>{{ $evidenceSheet->company->name }}</strong>
                </div>
            </div>
        </div>
        <div class="signature-block">
            <div class="signature-title">Datum</div>
            <div class="signature-line">
                <div style="margin-top: 5px; font-size: 11px;">
                    {{ now()->format('d.m.Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>EcoFlow - Digitalni sistem za upravljanje otpadom</strong></p>
        <p>Ovaj dokument je automatski generisan elektronski.</p>
        <p>ID evidencije: <strong>{{ $evidenceSheet->id }}</strong> | Generisano: {{ now()->format('d.m.Y H:i:s') }}</p>
    </div>
</body>
</html>

