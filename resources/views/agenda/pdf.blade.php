<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <title>सभेची नोटीस</title>
    <style>
        body {
            font-family: 'freeserif', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 16px;
            line-height: 1.6;
        }

        .page-border {
            border: 3px solid #000;
            padding: 25px;
            margin: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-and-header {
            text-align: center;
        }

        .logo {
            width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .title-1 { font-size: 22px; font-weight: bold; display: block; }
        .title-2 { font-size: 20px; display: block; }
        .title-3 { font-size: 18px; display: block; }
        .title-4 { font-size: 18px; display: block; }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        table td {
            padding: 4px 0;
            vertical-align: top;
        }

        p {
            text-align: justify;
            margin: 10px 0;
        }

        .meeting-info {
            margin-top: 15px;
        }

        .subject {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
        }

        .footer {
            text-align: right;
            margin-top: 40px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="page-border">
        <!-- Logo and Header (vertically stacked) -->
        <div class="logo-and-header">
            <img src="{{ public_path('admin/images/PMC-logo.png') }}" alt="PMC Logo" class="logo">
            <span class="title-1">पनवेल महानगरपालिका</span>
            <span class="title-2">सभेची नोटीस</span>
            <span class="title-3">स्थायी समिती सभा कामकाज पार पाडण्याबाबत</span>
            <span class="title-3">प्रशासकाची सभा क्र.४७/११४</span>
            <span class="title-4">सोमवार दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</span>
        </div>

        <!-- Reference Details Table -->
        <table>
            <tr>
                <td style="width: 80%;">जा.क्र.पमपा./सचिव/१९-२४/प्र.क्र.७२/१५/२४</td>
                <td style="text-align: right;">दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</td>
            </tr>
        </table>

        <!-- Body Paragraphs -->
        <p>
            ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदीनुसार विविध कामकाज पार पाहण्यासाठी काही प्रस्तावांना स्थायी समितीची पूर्व मान्यता घेणे आवश्यक आहे आणि,
        </p>
        <p>
            ज्या अर्थी, पनवेल महानगरपालिकेची मुदत दिनांक ०९ जुलै, २०२२ रोजी संपलेली असल्याने सद्यः स्थितीत स्थायी समिती अस्तित्वात नाही. आणि,
        </p>
        <p>
            ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमाखाली सर्व अधिकारांचा वापर करण्यासाठी आणि तिची सर्व कामे व कर्तव्ये पार पाडण्यासाठी महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदी व विशेषतः कलम ४५२ 'अ' च्या (१ अ) व (१ ब) मधील तरतुदींनुसार पनवेल महानगरपालिका येथे प्रशासक पदी आयुक्त, पनवेल महानगरपालिका यांची नियुक्ती महाराष्ट्र शासनाने केलेली आहे,
        </p>
        <p>
            त्या अर्थी, स्थायी समितीच्या मान्यतेने पार पाडावयाचे कामकाज पूर्ण करण्यासाठी प्रशासक यांच्या अध्यक्षतेखाली खालील प्रस्तावांवर निर्णय घेणेकरीता बैठकीचे आयोजन करण्यात येत आहे.
        </p>

        <!-- Meeting Info -->
        <div class="meeting-info">
            <p><b>बैठकीचे स्थळ :</b> {{ $agenda->place }}</p>
            <p><b>दिनांक :</b> {{ date('d/m/Y', strtotime($agenda->date)) }}</p>
            <p><b>वेळ :</b> {{ date('h:i A', strtotime($agenda->time)) }}</p>
        </div>

        <!-- Subject List -->
        <div class="subject">विषय सूची</div>
        @foreach($goshwaras as $goshwara)
            <p>{{ $loop->iteration }}. {{ $goshwara?->goshwara?->subject }}</p>
        @endforeach

        <!-- Footer -->
        <div class="footer">
            मा. प्रशासकाकडील <br> कार्यालयीन कामकाज
        </div>
    </div>
</body>
</html>
