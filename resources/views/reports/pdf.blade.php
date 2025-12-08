<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izveštaj o otpadu - {{ $waste->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.6;
            background: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            color: white;
            padding: 40px 30px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .header-content {
            position: relative;
            z-index: 1;
        }
        .header h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .header .subtitle {
            font-size: 14px;
            opacity: 0.95;
            font-weight: 500;
        }
        .header .report-id {
            position: absolute;
            top: 20px;
            right: 30px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .content {
            padding: 0 30px 30px;
        }
        .section {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #059669;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 3px solid #10b981;
            display: flex;
            align-items: center;
        }
        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: #10b981;
            margin-right: 12px;
            border-radius: 2px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .info-item {
            padding: 12px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-item:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .info-value {
            font-size: 13px;
            color: #111827;
            font-weight: 500;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .status-prijavljen {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        .status-u-obradi {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        .status-preuzet {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        .highlight-box {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border-left: 4px solid #10b981;
            padding: 18px;
            margin-top: 15px;
            border-radius: 8px;
        }
        .highlight-label {
            font-weight: bold;
            color: #065f46;
            margin-bottom: 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .highlight-content {
            color: #047857;
            font-size: 12px;
            line-height: 1.8;
        }
        .notes-box {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 18px;
            margin-top: 15px;
            border-radius: 8px;
        }
        .notes-label {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .notes-content {
            color: #78350f;
            font-size: 12px;
            line-height: 1.8;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 9px;
        }
        .footer-logo {
            font-weight: bold;
            color: #059669;
            font-size: 11px;
            margin-bottom: 5px;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
            margin: 15px 0;
        }
        .operator-info {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .date-time {
            color: #6b7280;
            font-size: 10px;
            margin-top: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table td {
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }
        table td:first-child {
            width: 40%;
            font-weight: 600;
            color: #6b7280;
            font-size: 10px;
            text-transform: uppercase;
        }
        table td:last-child {
            color: #111827;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="report-id">ID: #{{ $waste->id }}</div>
        <div class="header-content">
            <h1>IZVEŠTAJ O OTPADU</h1>
            <div class="subtitle">EcoFlow - Digitalni sistem za upravljanje otpadom</div>
        </div>
    </div>

    <div class="content">
        <!-- Osnovne informacije -->
        <div class="section">
            <div class="section-title">Osnovne informacije</div>
            <table>
                <tr>
                    <td>ID zapisa</td>
                    <td>#{{ $waste->id }}</td>
                </tr>
                <tr>
                    <td>Datum izveštaja</td>
                    <td>{{ now()->format('d.m.Y H:i') }}</td>
                </tr>
                <tr>
                    <td>Kompanija</td>
                    <td><strong>{{ $waste->company->name }}</strong></td>
                </tr>
                <tr>
                    <td>Lokacija</td>
                    <td><strong>{{ $waste->location->naziv }}</strong></td>
                </tr>
                <tr>
                    <td>Adresa lokacije</td>
                    <td>{{ $waste->location->adresa }}</td>
                </tr>
                <tr>
                    <td>Tip otpada</td>
                    <td><strong>{{ $waste->tip_otpada }}</strong></td>
                </tr>
                <tr>
                    <td>Količina</td>
                    <td><strong style="color: #059669; font-size: 14px;">{{ number_format($waste->kolicina, 2, ',', '.') }} kg</strong></td>
                </tr>
                <tr>
                    <td>Datum nastanka</td>
                    <td>{{ $waste->datum_nastanka->format('d.m.Y') }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        @if($waste->status === 'Prijavljen')
                            <span class="status-badge status-prijavljen">{{ $waste->status }}</span>
                        @elseif($waste->status === 'U obradi')
                            <span class="status-badge status-u-obradi">{{ $waste->status }}</span>
                        @else
                            <span class="status-badge status-preuzet">{{ $waste->status }}</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- Informacije o preuzimanju -->
        @if($waste->status === 'Preuzet' && $waste->operator)
        <div class="section">
            <div class="section-title">Informacije o preuzimanju</div>
            <div class="operator-info">
                <table>
                    <tr>
                        <td>Operater</td>
                        <td><strong>{{ $waste->operator->name }}</strong></td>
                    </tr>
                    <tr>
                        <td>Broj dozvole</td>
                        <td><strong>{{ $waste->operator->broj_dozvole }}</strong></td>
                    </tr>
                    @if($waste->operator->kontakt_osoba)
                    <tr>
                        <td>Kontakt osoba</td>
                        <td><strong>{{ $waste->operator->kontakt_osoba }}</strong></td>
                    </tr>
                    @endif
                    @if($waste->operator->telefon)
                    <tr>
                        <td>Telefon</td>
                        <td><strong>{{ $waste->operator->telefon }}</strong></td>
                    </tr>
                    @endif
                    <tr>
                        <td>Datum preuzimanja</td>
                        <td>
                            <strong>{{ $waste->datum_preuzimanja->format('d.m.Y') }}</strong>
                            <div class="date-time">{{ $waste->datum_preuzimanja->format('H:i') }} časova</div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        @endif

        <!-- Napomene -->
        @if($waste->napomena)
        <div class="section">
            <div class="section-title">Napomene</div>
            <div class="notes-box">
                <div class="notes-label">Dodatne informacije</div>
                <div class="notes-content">{{ $waste->napomena }}</div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">EcoFlow</div>
            <p>Ovaj izveštaj je automatski generisan od strane sistema za upravljanje otpadom.</p>
            <p>Datum generisanja: {{ now()->format('d.m.Y H:i:s') }}</p>
            <p style="margin-top: 10px; color: #9ca3af;">© {{ date('Y') }} EcoFlow. Sva prava zadržana.</p>
        </div>
    </div>
</body>
</html>
