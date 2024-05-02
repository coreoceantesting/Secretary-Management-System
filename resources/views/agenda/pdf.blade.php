<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: 'freeserif', 'normal';
            padding: 0;
            margin: 0;
        }

        header {
            text-align: center;
            border-bottom: 1px solid #000;
        }

        header h2 {
            line-height: 0;
        }

        .subject {
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <span style="font-size: 21px; font-weight:900;">पनवेल महानगरपालिका</span><br>
        <span style="font-size: 19px;">सभेची नोटीस</span><br>
        <span style="font-size: 18px;">स्थायी समिती सभा कामकाज पार पाडण्याबाबत प्रशासकाची सभा क्र.४७/११४</span><br>
        <span style="font-size: 20px;">सोमवार दिनांक : {{ date('d/m/Y', strtotime($agenda->date)) }}</span><br>
    </header>
    <table>
        <tr>
            <td style="width:80%">जा.क्र.पमपा./सचिव/१९-२४/प्र.क्र.७२/१५/२४</td>
            <td>दिनांक {{ date('d/m/Y', strtotime($agenda->date)) }}</td>
        </tr>
    </table>
    <p>
        @for($i=0; $i < 15; $i++) &nbsp; @endfor ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदीनुसार विविध कामकाज पार पाहण्यासाठी काही प्रस्तावांना स्थायी समितीची पूर्व मान्यता घेणे आवश्यक आहे आणि, </p>
    <p>@for($i=0; $i < 15; $i++)&nbsp;@endfor ज्या अर्थी, पनवेल महानगरपालिकेची मुदत दिनांक ०९ जुलै, २०२२ रोजी संपलेली असल्याने सद्यः स्थितीत स्थायी समिती अस्तित्वात नाही. आणि,</p>
     <p>@for($i=0; $i < 15; $i++)&nbsp;@endfor ज्या अर्थी, महाराष्ट्र महानगरपालिका अधिनियमाखाली सर्व अधिकारांचा वापर करण्यासाठी आणि तिची सर्व कामे व कर्तव्ये पार पाडण्यासाठी महाराष्ट्र महानगरपालिका अधिनियमातील तरतुदी व विशेषतः कलम ४५२ 'अ' च्या (१ अ) व (१ ब) मधील तरतुदींनुसार पनवेल महानगरपालिका येथे प्रशासक पदी आयुक्त, पनवेल महानगरपालिका यांची नियुक्ती महाराष्ट्र शासनाने केलेली आहे,</p>
    <p>@for($i=0; $i < 15; $i++)&nbsp;@endfor त्या अर्थी, स्थायी समितीच्या मान्यतेने पार पाडावयाचे कामकाज पूर्ण करण्यासाठी प्रशासक यांच्या अध्यक्षतेखाली खालील प्रस्तावांवर निर्णय घेणेकरीता बैठकीचे आयोजन करण्यात येत आहे.</p>
    <p>
        <b>बैठकीचे स्थळ :</b> {{ $agenda->place }}<br>
        <b>दिनांक :</b> {{ date('d/m/Y', strtotime($agenda->date)) }}<br>
        <b>वेळ :</b> {{ date('h:i A', strtotime($agenda->time)) }}<br>
    </p>
    <section class="subject"><b style="font-size: 21px;">विषय सूची</b></section>
    @foreach($goshwaras as $goshwara)
    <p>{{ $loop->iteration }}. {{ $goshwara?->goshwara?->subject }}</p>
    @endforeach

    <table style="width: 100%">
        <tr>
            <th align="right">मा. प्रशासकाकडील <br> कार्यालयीन कामकाज</th>
        </tr>
    </table>
</body>

</html>
