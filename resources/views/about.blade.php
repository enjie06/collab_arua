@extends('layouts.main')
@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Wisata Sumatera Utara</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .about-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 8rem 4rem 4rem;
            text-align: center;
            margin-top: 70px;
        }
   
        .about-hero h1 {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 1rem;
            color: white;
        }

        .about-hero p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 700px;
            margin: 0 auto;
        }

        /* About Content */
        .about-content {
            padding: 6rem 4rem;
            background: #0f0f1e;
        }

        .about-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .mv-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 3rem;
            transition: all 0.3s;
        }

        /* Team Section */
        .team-section {
            margin-bottom: 6rem;
        }

        .team-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 3rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .team-grid {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            align-items: center;
        }

        .team-row {
            display: flex;
            gap: 2rem;
            justify-content: center;
        }

        .team-card {
         background: rgba(255, 255, 255, 0.05);
         border: 1px solid rgba(255, 255, 255, 0.1);
         border-radius: 15px;
         padding: 1.5rem;
         width: 180px;
         text-align: center;
         transition: all 0.3s;
         gap: 1.5rem;
}

        .team-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(102, 126, 234, 0.5);
            transform: translateY(-10px);

        }

        .team-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 1rem;
        }

       .team-name {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
        }


        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 4rem;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
        }

        .cta-section p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 2.5rem;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
}
        /* Bottom CTA Banner */
        .bottom-cta-banner {
            position: relative;
            height: 300px;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), 
            url('{{ asset("images/danau.jpg") }}') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: repeating-linear-gradient(
                45deg,
                rgba(102, 126, 234, 0.05),
                rgba(102, 126, 234, 0.05) 10px,
                transparent 10px,
                transparent 20px
            );
            pointer-events: none;
        }

        .banner-content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 2rem;
        }

        .banner-content h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 2rem;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
        }

        .banner-btn {
            display: inline-block;
            padding: 1.2rem 3rem;
            background: #a8e063;
            color: #1a1a2e;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 1px;
            transition: all 0.3s;
            box-shadow: 0 10px 30px rgba(168, 224, 99, 0.4);
            text-transform: uppercase;
        }

        .banner-btn:hover {
            background: #93d04b;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(168, 224, 99, 0.6);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .mission-vision {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .team-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .about-hero {
                padding: 6rem 2rem 3rem;
            }

            .about-hero h1 {
                font-size: 2.5rem;
            }

            .about-content {
                padding: 4rem 2rem;
            }

            .banner-content h2 {
                font-size: 1.8rem;
            }

            .banner-btn {
                font-size: 1rem;
                padding: 1rem 2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <section class="about-hero">
        <h1>Tentang Kami</h1>
        <p>Platform pencarian wisata berbasis Web Semantik untuk menghubungkan Anda dengan keindahan Sumatera Utara</p>
    </section>

    <!-- About Content -->
    <section class="about-content">
        <div class="about-container">

             <!-- Team -->
             <div class="team-section">
                <h2 class="team-title">Tim Kami</h2>
                
                <div class="team-grid">
                    <!-- Baris Atas: 3 Orang -->
                    <div class="team-row top">
                        <div class="team-card">
                            <img src="{{ asset('images/member1.jpg') }}" alt="Nama Anggota 1" class="team-photo">
                            <h3 class="team-name">Anggie Rahmadina Nasution</h3>
                        </div>

                        <div class="team-card">
                            <img src="{{ asset('images/member2.jpg') }}" alt="Arua" class="team-photo">
                            <h3 class="team-name">Miranda Nainggolan</h3>
                        </div>

                        <div class="team-card">
                            <img src="{{ asset('images/member3.jpg') }}" alt="Nama Anggota 3" class="team-photo">
                            <h3 class="team-name">Vina Permata Sari</h3>
                        </div>
                    </div>

                    <!-- Baris Bawah: 2 Orang -->
                    <div class="team-row bottom">
                        <div class="team-card">
                            <img src="{{ asset('images/member4.jpg') }}" alt="Nama Anggota 4" class="team-photo">
                            <h3 class="team-name">Nayla Vania</h3>
                        </div>

                        <div class="team-card">
                            <img src="{{ asset('images/member5.jpg') }}" alt="Nama Anggota 5" class="team-photo">
                            <h3 class="team-name">Natali Desi Sembiring</h3>
                        </div>
                    </div>
                </div>
            </div>
    </section>

            <!-- CTA Section -->
            <section class="bottom-cta-banner">
    <div class="banner-overlay"></div>
    <div class="banner-content">
        <h2>Mulai menjelajahi Sumatera Utara?</h2>
        <a href="/" class="banner-btn">
            START EXPLORING →
        </a>
    </div>
</section>


    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>

@endsection
