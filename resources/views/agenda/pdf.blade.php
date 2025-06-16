<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <title>सभेची नोटीस</title>
    <style>
        body {
            font-family: 'freeserif', 'normal';
            margin: 0;
            padding: 0;
            font-size: 16px;
            line-height: 1.8;
        }

        .page-border {
            margin: 20px;
            padding: 20px;
            border: 2px solid black;
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .logo {
            width: 80px;
            height: 80px;
        }

        .header-text {
            text-align: center;
            flex: 1;
            padding: 0 20px;
        }

        .header-text span {
            display: block;
        }

        .title-1 { font-size: 21px; font-weight: bold; }
        .title-2 { font-size: 19px; }
        .title-3 { font-size: 18px; }
        .title-4 { font-size: 20px; }

        table {
            width: 100%;
            margin-top: 20px;
        }

        p {
            text-align: justify;
            margin: 10px 0;
        }

        .subject {
            text-align: center;
            font-size: 21px;
            font-weight: bold;
            margin-top: 25px;
        }

        .footer {
            text-align: right;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="page-border">
        <!-- Header -->
        <div class="header-flex">
            <img src="{{ public_path('admin/images/PMC-logo.png') }}" alt="Left Logo" class="logo">
            <div class="header-text">
                <span class="title-1">पनवेल महानगरपालिका</span>
                <span class="title-2">सभेची नोटीस</span>
                <span class="title-3">स्थायी समिती सभा कामकाज पार पाडण्याबाबत प्रशासकाची सभा क्र.४७/११४</span>
                <span class="title-4">सोमवार दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</span>
            </div>
            <img src="{{ public_path('admin/images/PMC-logo.png') }}" alt="Right Logo" class="logo">
        </div>

        <!-- Reference Info -->
        <table>
            <tr>
                <td style="width:80%">जा.क्र.पमपा./सचिव/१९-२४/प्र.क्र.७२/१५/२४</td>
                <td>दिनांक {{ date('d/m/Y', strtotime($agenda->date)) }}</td>
            </tr>
        </table>

        <!-- Paragraphs -->
        <p>@for($i=0; $i < 15; $i++) &nbsp; @endfor
            ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदीनुसार विविध कामकाज पार पाहण्यासाठी काही प्रस्तावांना स्थायी समितीची पूर्व मान्यता घेणे आवश्यक आहे आणि,</p>

        <p>@for($i=0; $i < 15; $i++) &nbsp; @endfor
            ज्या अर्थी, पनवेल महानगरपालिकेची मुदत दिनांक ०९ जुलै, २०२२ रोजी संपलेली असल्याने सद्यः स्थितीत स्थायी समिती अस्तित्वात नाही. आणि,</p>

        <p>@for($i=0; $i < 15; $i++) &nbsp; @endfor
            ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमाखाली सर्व अधिकारांचा वापर करण्यासाठी आणि तिची सर्व कामे व कर्तव्ये पार पाडण्यासाठी महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदी व विशेषतः कलम ४५२ 'अ' च्या (१ अ) व (१ ब) मधील तरतुदींनुसार पनवेल महानगरपालिका येथे प्रशासक पदी आयुक्त, पनवेल महानगरपालिका यांची नियुक्ती महाराष्ट्र शासनाने केलेली आहे,</p>

        <p>@for($i=0; $i < 15; $i++) &nbsp; @endfor
            त्या अर्थी, स्थायी समितीच्या मान्यतेने पार पाडावयाचे कामकाज पूर्ण करण्यासाठी प्रशासक यांच्या अध्यक्षतेखाली खालील प्रस्तावांवर निर्णय घेणेकरीता बैठकीचे आयोजन करण्यात येत आहे.</p>

        <!-- Meeting Info -->
        <p>
            <b>बैठकीचे स्थळ :</b> {{ $agenda->place }}<br>
            <b>दिनांक :</b> {{ date('d/m/Y', strtotime($agenda->date)) }}<br>
            <b>वेळ :</b> {{ date('h:i A', strtotime($agenda->time)) }}
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
    </div>
</body>
</html>
