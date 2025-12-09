<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ugovor o preuzimanju otpada - {{ $contract->contract_number }}</title>
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
            line-height: 1.7;
            background: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 40px 30px;
            margin-bottom: 35px;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }
        .header-content {
            position: relative;
            z-index: 1;
        }
        .header h1 {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 12px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid rgba(255, 255, 255, 0.3);
            font-size: 12px;
            font-weight: 500;
        }
        .content {
            padding: 0 35px 35px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 15px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 18px;
            padding-bottom: 10px;
            border-bottom: 3px solid #3b82f6;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }
        .info-block {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 1px solid #e2e8f0;
            border-left: 4px solid #3b82f6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .info-block-title {
            font-size: 12px;
            font-weight: bold;
            color: #1e3a8a;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-row {
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .info-label {
            font-weight: 600;
            color: #64748b;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 4px;
        }
        .info-value {
            color: #0f172a;
            font-size: 12px;
            font-weight: 500;
        }
        .subject-section {
            background: #fef3c7;
            border-left: 5px solid #f59e0b;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .subject-text {
            font-size: 11px;
            line-height: 1.8;
            color: #78350f;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            overflow: hidden;
        }
        table thead {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }
        table th {
            color: white;
            padding: 14px 12px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        table th:first-child {
            width: 60px;
            text-align: center;
        }
        table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
            color: #1a1a1a;
        }
        table tbody tr:last-child td {
            border-bottom: none;
        }
        table tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        table tbody tr:hover {
            background: #f1f5f9;
        }
        .obligations {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin: 25px 0;
        }
        .obligation-block {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-left: 4px solid #0ea5e9;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .obligation-title {
            font-weight: bold;
            color: #0c4a6e;
            margin-bottom: 12px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .obligation-list {
            list-style: none;
            padding: 0;
        }
        .obligation-list li {
            padding: 8px 0;
            padding-left: 25px;
            position: relative;
            font-size: 10px;
            color: #0c4a6e;
            line-height: 1.6;
        }
        .obligation-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #0ea5e9;
            font-weight: bold;
            font-size: 12px;
        }
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin-top: 50px;
            padding-top: 40px;
            border-top: 3px solid #e2e8f0;
        }
        .signature-block {
            text-align: center;
        }
        .signature-title {
            font-weight: bold;
            margin-bottom: 50px;
            font-size: 12px;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .signature-line {
            border-top: 2px solid #1a1a1a;
            margin-top: 80px;
            padding-top: 8px;
            font-size: 10px;
            color: #475569;
        }
        .signature-name {
            font-weight: 600;
            color: #0f172a;
            margin-top: 5px;
        }
        .footer {
            margin-top: 50px;
            padding-top: 25px;
            border-top: 2px solid #e2e8f0;
            text-align: center;
            color: #64748b;
            font-size: 9px;
        }
        .footer-logo {
            font-weight: bold;
            color: #1e3a8a;
            font-size: 11px;
            margin-bottom: 8px;
        }
        .contract-number-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 10px;
        }
        .period-highlight {
            background: #dbeafe;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 600;
            color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>UGOVOR O PREUZIMANJU OTPADA</h1>
            <div class="header-meta">
                <div>Broj ugovora: <span class="contract-number-badge">{{ $contract->contract_number }}</span></div>
                <div>Datum sklapanja: {{ $contract->date_start->format('d.m.Y') }}</div>
            </div>
        </div>
    </div>

    <div class="content">
        <!-- Parties Information -->
        <div class="section">
            <div class="section-title">Strane ugovora</div>
            <div class="info-grid">
                <!-- Company Block -->
                <div class="info-block">
                    <div class="info-block-title">Generator otpada (Firma)</div>
                    <div class="info-row">
                        <div class="info-label">Naziv</div>
                        <div class="info-value">{{ $contract->company->name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">PIB</div>
                        <div class="info-value">{{ $contract->company->pib }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Adresa</div>
                        <div class="info-value">{{ $contract->company->adresa }}</div>
                    </div>
                    @if($contract->company->kontakt_osoba)
                    <div class="info-row">
                        <div class="info-label">Kontakt osoba</div>
                        <div class="info-value">{{ $contract->company->kontakt_osoba }}</div>
                    </div>
                    @endif
                    @if($contract->company->telefon)
                    <div class="info-row">
                        <div class="info-label">Telefon</div>
                        <div class="info-value">{{ $contract->company->telefon }}</div>
                    </div>
                    @endif
                    @if($contract->company->email)
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $contract->company->email }}</div>
                    </div>
                    @endif
                </div>

                <!-- Operator Block -->
                <div class="info-block">
                    <div class="info-block-title">Operater</div>
                    <div class="info-row">
                        <div class="info-label">Naziv</div>
                        <div class="info-value">{{ $contract->operator->name }}</div>
                    </div>
                    @if($contract->operator->broj_dozvole)
                    <div class="info-row">
                        <div class="info-label">Broj dozvole</div>
                        <div class="info-value">{{ $contract->operator->broj_dozvole }}</div>
                    </div>
                    @endif
                    @if($contract->operator->kategorija_dozvole)
                    <div class="info-row">
                        <div class="info-label">Kategorija dozvole</div>
                        <div class="info-value">{{ $contract->operator->kategorija_dozvole }}</div>
                    </div>
                    @endif
                    @if($contract->operator->adresa)
                    <div class="info-row">
                        <div class="info-label">Adresa</div>
                        <div class="info-value">{{ $contract->operator->adresa }}</div>
                    </div>
                    @endif
                    @if($contract->operator->kontakt_osoba)
                    <div class="info-row">
                        <div class="info-label">Kontakt osoba</div>
                        <div class="info-value">{{ $contract->operator->kontakt_osoba }}</div>
                    </div>
                    @endif
                    @if($contract->operator->telefon)
                    <div class="info-row">
                        <div class="info-label">Telefon</div>
                        <div class="info-value">{{ $contract->operator->telefon }}</div>
                    </div>
                    @endif
                    @if($contract->operator->email)
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $contract->operator->email }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Subject -->
        <div class="section">
            <div class="section-title">Predmet ugovora</div>
            <div class="subject-section">
                <div class="subject-text">
                    <strong>Ovim ugovorom</strong> operator se obavezuje da preuzme i zbrine sledeće vrste otpada u periodu 
                    <span class="period-highlight">{{ $contract->date_start->format('d.m.Y') }}</span>
                    @if($contract->date_end)
                        - <span class="period-highlight">{{ $contract->date_end->format('d.m.Y') }}</span>:
                    @else
                        - <span class="period-highlight">neograničeno</span>:
                    @endif
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Vrsta otpada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contract->waste_types as $index => $type)
                            <tr>
                                <td style="text-align: center; font-weight: 600;">{{ $index + 1 }}.</td>
                                <td><strong>{{ $type }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Obligations -->
        <div class="section">
            <div class="section-title">Obaveze strana</div>
            <div class="obligations">
                <div class="obligation-block">
                    <div class="obligation-title">Generator (Firma)</div>
                    <ul class="obligation-list">
                        <li>Obezbediti pravilno sortiranje otpada po vrstama prema važećim propisima</li>
                        <li>Pružiti tačne i ažurne podatke o količini i vrsti otpada</li>
                        <li>Omogućiti pristup lokaciji za preuzimanje otpada u dogovorenim terminima</li>
                        <li>Obavestiti operatera o svim promenama u planiranom otpadu najmanje 48h unapred</li>
                        <li>Obezbediti bezbedan pristup i uslove za rad operatera</li>
                    </ul>
                </div>
                <div class="obligation-block">
                    <div class="obligation-title">Operater</div>
                    <ul class="obligation-list">
                        <li>Preuzeti otpad u dogovorenom roku i na način propisan ovim ugovorom</li>
                        <li>Izdati potvrdu o preuzimanju otpada sa svim potrebnim podacima</li>
                        <li>Voditi evidenciju i dokumentaciju o preuzetom otpadu u skladu sa propisima</li>
                        <li>Postupati sa otpadom u skladu sa važećim zakonima i propisima</li>
                        <li>Obavestiti firmu o svim eventualnim problemima ili promenama</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Notes -->
        @if($contract->notes)
        <div class="section">
            <div class="section-title">Dodatne napomene</div>
            <div style="background: #f8fafc; border-left: 4px solid #64748b; border-radius: 8px; padding: 18px; font-size: 11px; line-height: 1.8; color: #334155;">
                {{ $contract->notes }}
            </div>
        </div>
        @endif

        <!-- Signatures -->
        <div class="signatures">
            <div class="signature-block">
                <div class="signature-title">Za firmu</div>
                <div style="margin-top: 80px;">
                    <div class="signature-line">
                        <div class="signature-name">{{ $contract->company->name }}</div>
                    </div>
                </div>
            </div>
            <div class="signature-block">
                <div class="signature-title">Za operatera</div>
                <div style="margin-top: 80px;">
                    <div class="signature-line">
                        <div class="signature-name">{{ $contract->operator->name }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">EcoFlow - Digitalni sistem za upravljanje otpadom</div>
            <p>Ovaj dokument je automatski generisan elektronski.</p>
            <p>Broj ugovora: <strong>{{ $contract->contract_number }}</strong> | Generisano: {{ now()->format('d.m.Y H:i:s') }}</p>
            <p style="margin-top: 8px; color: #94a3b8;">© {{ date('Y') }} EcoFlow. Sva prava zadržana.</p>
        </div>
    </div>
</body>
</html>
