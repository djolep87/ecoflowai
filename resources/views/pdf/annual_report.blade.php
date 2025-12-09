<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Godišnji izveštaj o otpadu - {{ $report->godina }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
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
            font-size: 22px;
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
        .year-badge {
            display: inline-block;
            background: #1a1a1a;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            font-weight: bold;
            margin-left: 10px;
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
        .summary-section {
            background: #f8f9fa;
            border: 2px solid #1a1a1a;
            padding: 20px;
            margin-bottom: 30px;
        }
        .summary-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
            border-bottom: 2px solid #1a1a1a;
            padding-bottom: 8px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
        }
        .summary-item {
            padding: 15px;
            background: white;
            border: 1px solid #1a1a1a;
        }
        .summary-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #1a1a1a;
        }
        .waste-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            border: 2px solid #1a1a1a;
        }
        .waste-table thead {
            background: #1a1a1a;
            color: white;
        }
        .waste-table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .waste-table th:first-child {
            width: 50px;
            text-align: center;
        }
        .waste-table th:last-child {
            text-align: right;
        }
        .waste-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        .waste-table tbody tr:last-child td {
            border-bottom: none;
        }
        .waste-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        .waste-table td:last-child {
            text-align: right;
            font-weight: 600;
        }
        .total-row {
            background: #1a1a1a !important;
            color: white;
            font-weight: bold;
        }
        .total-row td {
            padding: 15px 12px;
            font-size: 12px;
        }
        .notes-section {
            border: 2px solid #1a1a1a;
            padding: 20px;
            margin-bottom: 30px;
            min-height: 80px;
        }
        .notes-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .notes-text {
            font-size: 11px;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Godišnji izveštaj o otpadu</h1>
        <h2>Godina: <span class="year-badge">{{ $report->godina }}</span></h2>
    </div>

    <!-- Company Information -->
    <div class="company-info">
        <div class="company-info-title">Podaci o firmi</div>
        <div class="info-row">
            <div class="info-label">Naziv firme:</div>
            <div class="info-value">{{ $report->company->name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">PIB:</div>
            <div class="info-value">{{ $report->company->pib }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Adresa:</div>
            <div class="info-value">{{ $report->company->adresa }}</div>
        </div>
        @if($report->company->maticni_broj)
        <div class="info-row">
            <div class="info-label">Matični broj:</div>
            <div class="info-value">{{ $report->company->maticni_broj }}</div>
        </div>
        @endif
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <div class="summary-title">Pregled izveštaja</div>
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-label">Ukupna količina otpada</div>
                <div class="summary-value">{{ number_format($report->ukupno_kolicina, 2, ',', '.') }} kg</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Broj vrsta otpada</div>
                <div class="summary-value">{{ $report->broj_vrsta_otpada }}</div>
            </div>
        </div>
    </div>

    <!-- Waste by Type Table -->
    <div style="margin-bottom: 30px;">
        <div style="font-size: 14px; font-weight: bold; margin-bottom: 15px; text-transform: uppercase; border-bottom: 2px solid #1a1a1a; padding-bottom: 8px;">
            Detaljan pregled po vrstama otpada
        </div>
        <table class="waste-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vrsta otpada</th>
                    <th>Broj zapisa</th>
                    <th>Ukupna količina</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wasteByType as $index => $waste)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}.</td>
                        <td><strong>{{ $waste['type'] }}</strong></td>
                        <td>{{ $waste['count'] }}</td>
                        <td>{{ number_format($waste['total'], 2, ',', '.') }} {{ $waste['unit'] }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align: right; padding-right: 20px;">UKUPNO:</td>
                    <td>{{ number_format($report->ukupno_kolicina, 2, ',', '.') }} kg</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Notes Section -->
    @if($report->napomena)
    <div class="notes-section">
        <div class="notes-title">Napomena</div>
        <div class="notes-text">
            {{ $report->napomena }}
        </div>
    </div>
    @endif

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-block">
            <div class="signature-title">Potpis odgovornog lica</div>
            <div class="signature-line">
                <div style="margin-top: 5px; font-size: 11px;">
                    <strong>{{ $report->company->name }}</strong>
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
        <p>ID izveštaja: <strong>{{ $report->id }}</strong> | Generisano: {{ now()->format('d.m.Y H:i:s') }}</p>
    </div>
</body>
</html>

