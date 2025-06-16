<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <title>सभेची नोटीस</title>
    <style>
        body {
            font-family: 'freeserif', 'normal';
            padding: 0;
            margin: 0;
            font-size: 16px;
            line-height: 1.8;
        }

        header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding: 10px 0 20px;
            position: relative;
        }

        .logo-left {
            position: absolute;
            top: 10px;
            left: 30px;
        }

        .logo-right {
            position: absolute;
            top: 10px;
            right: 30px;
        }

        .header-center {
            display: inline-block;
            padding: 0 100px;
        }

        .subject {
            text-align: center;
            font-size: 21px;
            margin-top: 30px;
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        table td {
            vertical-align: top;
        }

        p {
            text-align: justify;
            margin: 10px 40px;
        }

        .footer {
            text-align: right;
            margin-right: 40px;
            margin-top: 50px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo-left">
            <img src="{{ public_path('admin/images/PMC-logo.png') }}" alt="Left Logo" height="80" width="80">
        </div>
        <div class="logo-right">
            <img src="{{ public_path('admin/images/PMC-logo.png') }}" alt="Right Logo" height="80" width="80">
        </div>

        <div class="header-center">
            <div style="font-size: 21px; font-weight: 900;">पनवेल महानगरपालिका</div>
            <div style="font-size: 19px;">सभेची नोटीस</div>
            <div style="font-size: 18px;">स्थायी समिती सभा कामकाज पार पाडण्याबाबत प्रशासकाची सभा क्र.४७/११४</div>
            <div style="font-size: 20px;">सोमवार दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</div>
        </div>
    </header>

    <table>
        <tr>
            <td style="width: 80%;">जा.क्र.पमपा./सचिव/१९-२४/प्र.क्र.७२/१५/२४</td>
            <td>दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</td>
        </tr>
    </table>

    <p>
        @for($i=0; $i < 15; $i++) &nbsp; @endfor
        ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदीनुसार विविध कामकाज पार पाहण्यासाठी काही प्रस्तावांना स्थायी समितीची पूर्व मान्यता घेणे आवश्यक आहे आणि,
    </p>

    <p>
        @for($i=0; $i < 15; $i++) &nbsp; @endfor
        ज्या अर्थी, पनवेल महानगरपालिकेची मुदत दिनांक ०९ जुलै, २०२२ रोजी संपलेली असल्याने सद्यः स्थितीत स्थायी समिती अस्तित्वात नाही. आणि,
    </p>

    <p>
        @for($i=0; $i < 15; $i++) &nbsp; @endfor
        ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमाखाली सर्व अधिकारांचा वापर करण्यासाठी आणि तिची सर्व कामे व कर्तव्ये पार पाडण्यासाठी महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदी व विशेषतः कलम ४५२ 'अ' च्या (१ अ) व (१ ब) मधील तरतुदींनुसार पनवेल महानगरपालिका येथे प्रशासक पदी आयुक्त, पनवेल महानगरपालिका यांची नियुक्ती महाराष्ट्र शासनाने केलेली आहे,
    </p>

    <p>
        @for($i=0; $i < 15; $i++) &nbsp; @endfor
        त्या अर्थी, स्थायी समितीच्या मान्यतेने पार पाडावयाचे कामकाज पूर्ण करण्यासाठी प्रशासक यांच्या अध्यक्षतेखाली खालील प्रस्तावांवर निर्णय घेणेकरीता बैठकीचे आयोजन करण्यात येत आहे.
    </p>

    <p>
        <strong>बैठकीचे स्थळ :</strong> {{ $agenda->place }}<br>
        <strong>दिनांक :</strong> {{ date('d/m/Y', strtotime($agenda->date)) }}<br>
        <strong>वेळ :</strong> {{ date('h:i A', strtotime($agenda->time)) }}
    </p>

    <div class="subject">विषय सूची</div>

    @foreach($goshwaras as $goshwara)
        <p>{{ $loop->iteration }}. {{ $goshwara?->goshwara?->subject }}</p>
    @endforeach

    <div class="footer">
        मा. प्रशासकाकडील <br> कार्यालयीन कामकाज
    </div>

</body>
</html>
