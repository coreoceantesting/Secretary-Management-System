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

        .header-flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 40px 10px;
            border-bottom: 1px solid #000;
        }

        .logo {
            width: 80px;
        }

        .header-title {
            flex: 1;
            text-align: center;
        }

        .header-title div {
            font-weight: bold;
        }

        .header-title .title-main {
            font-size: 21px;
        }

        .header-title .title-sub {
            font-size: 19px;
        }

        .header-title .title-desc {
            font-size: 18px;
        }

        .header-title .title-date {
            font-size: 18px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            padding: 0 40px;
        }

        p {
            text-align: justify;
            margin: 10px 40px;
        }

        .subject {
            text-align: center;
            font-size: 21px;
            margin-top: 30px;
            font-weight: bold;
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

    <!-- Header with both logos and centered title -->
    <div class="header-flex">
        <div class="logo">
            <img src="{{ public_path('admin/images/PMC-logo.png') }}" alt="Logo Left" height="80" width="80">
        </div>

        <div class="header-title">
            <div class="title-main">पनवेल महानगरपालिका</div>
            <div class="title-sub">सभेची नोटीस</div>
            <div class="title-desc">स्थायी समिती सभा कामकाज पार पाडण्याबाबत प्रशासकाची सभा क्र.४७/११४</div>
            <div class="title-date">सोमवार दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</div>
        </div>

        <div class="logo">
            <img src="{{ public_path('admin/images/PMC-logo.png') }}" alt="Logo Right" height="80" width="80">
        </div>
    </div>

    <!-- Letter numbers and date -->
    <table>
        <tr>
            <td>जा.क्र.पमपा./सचिव/१९-२४/प्र.क्र.७२/१५/२४</td>
            <td style="text-align: right;">दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</td>
        </tr>
    </table>

    <!-- Content Paragraphs -->
    <p>ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदीनुसार विविध कामकाज पार पाहण्यासाठी काही प्रस्तावांना स्थायी समितीची पूर्व मान्यता घेणे आवश्यक आहे आणि,</p>
    <p>ज्या अर्थी, पनवेल महानगरपालिकेची मुदत दिनांक ०९ जुलै, २०२२ रोजी संपलेली असल्याने सद्यः स्थितीत स्थायी समिती अस्तित्वात नाही. आणि,</p>
    <p>ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमाखाली सर्व अधिकारांचा वापर करण्यासाठी आणि तिची सर्व कामे व कर्तव्ये पार पाडण्यासाठी महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदी व विशेषतः कलम ४५२ 'अ' च्या (१ अ) व (१ ब) मधील तरतुदींनुसार पनवेल महानगरपालिका येथे प्रशासक पदी आयुक्त, पनवेल महानगरपालिका यांची नियुक्ती महाराष्ट्र शासनाने केलेली आहे,</p>
    <p>त्या अर्थी, स्थायी समितीच्या मान्यतेने पार पाडावयाचे कामकाज पूर्ण करण्यासाठी प्रशासक यांच्या अध्यक्षतेखाली खालील प्रस्तावांवर निर्णय घेणेकरीता बैठकीचे आयोजन करण्यात येत आहे.</p>

    <!-- Meeting Info -->
    <p>
        <strong>बैठकीचे स्थळ :</strong> {{ $agenda->place }}<br>
        <strong>दिनांक :</strong> {{ date('d/m/Y', strtotime($agenda->date)) }}<br>
        <strong>वेळ :</strong> {{ date('h:i A', strtotime($agenda->time)) }}
    </p>

    <!-- Subject List -->
    <div class="subject">विषय सूची</div>

    @foreach($goshwaras as $goshwara)
        <p>{{ $loop->iteration }}. {{ $goshwara?->goshwara?->subject }}</p>
    @endforeach

    <!-- Footer -->
    <div class="footer">
        मा. प्रशासकाकडील <br> कार्यालयीन कामकाज
    </div>

</body>
</html>
