<style>
    :root {
        --primary-color: #1a3c8f;
        --secondary-color: #ffcc00;
        --text-color: #333;
        --light-gray: #f8f9fa;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--text-color);
        overflow-x: hidden;
    }

    /* Header Styles */
    .header {
        background-color: var(--secondary-color);
        padding: 10px 0;
    }

    .logo-container {
        display: flex;
        align-items: center;
    }

    .logo-container img {
        height: 40px;
        margin-right: 10px;
    }

    .logo-text {
        font-weight: bold;
        font-size: 1.2rem;
        margin: 0;
        line-height: 1.2;
    }

    .logo-text small {
        font-size: 0.7rem;
        display: block;
    }

    .nav-link {
        color: var(--text-color) !important;
        font-weight: 500;
        padding: 0.5rem 1rem;
        margin: 0 0.2rem;
    }

    .nav-link:hover {
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 4px;
    }

    /* Hero Section */
    .hero-section {
        padding: 4rem 0;
        background-color: white;
    }

    .hero-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 1.5rem;
        margin-top: 20px;
        font-size: 2rem;
        
    }

    .hero-title span {
        color: var(--primary-color);
        font-weight: bold;
    }

    .hero-subtitle {
        color: #666;
        margin-bottom: 2rem;
        font-size: 1rem;
    }

    .btn-survey {
        background-color: white;
        color: var(--primary-color);
        padding: 0.5rem 2rem;
        border-radius: 30px;
        font-weight: 600;
        border: 2px solid var(--primary-color);
        transition: all 0.3s;
        margin-bottom: 30px; 
    }

    .btn-survey:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-survey-footer {
        background-color: var(--secondary-color);
        color: var(--primary-color);
        padding: 0.5rem 2rem;
        border-radius: 30px;
        font-weight: 600;
        border: none;
        transition: all 0.3s;
    }

    .btn-survey-footer:hover {
        background-color: #e6b800;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .circle-image-container {
        position: relative;
        width: 100%;
        max-width: 400px;
        margin: 0 auto;
    }

    .circle-bg {
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: var(--primary-color);
        border-radius: 50%;
        z-index: 1;
        top: 10px;
        left: 10px;
    }

    .circle-image {
        position: relative;
        width: 100%;
        padding-bottom: 100%;
        border-radius: 50%;
        overflow: hidden;
        z-index: 2;
    }

    .circle-image img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* About Section */
    .about-section {
        padding: 4rem 0;
        background-color: var(--light-gray);
    }

    .section-title {
        font-weight: bold;
        font-size: 0.9rem;
        text-transform: uppercase;
        color: #777;
        margin-bottom: 1rem;
    }

    .about-title {
        font-weight: bold;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }

    .about-title span {
        color: var(--primary-color);
    }

    .about-text {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #555;
    }

    .about-image {
        max-width: 100%;
        height: auto;
    }

    /* Features Section */
    .features-section {
        padding: 4rem 0;
        background-color: white;
    }

    .feature-card {
        display: flex;
        margin-bottom: 2rem;
    }

    .feature-number {
        width: 60px;
        height: 60px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
        margin-right: 1.5rem;
        flex-shrink: 0;
    }

    .feature-content h3 {
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .feature-content p {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0;
    }

    /* Benefits Section */
    .benefits-section {
        padding: 4rem 0;
        background-color: var(--light-gray);
    }

    .benefits-title {
        font-weight: bold;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }

    .benefits-title span {
        color: var(--primary-color);
    }

    .benefits-text {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #555;
    }

    /* Goals Section */
    .goals-section {
        padding: 4rem 0;
        background-color: white;
    }

    .goals-title {
        font-weight: bold;
        font-size: 1.8rem;
        margin-bottom: 1.5rem;
    }

    .goals-title span {
        color: var(--primary-color);
    }

    .goals-list {
        list-style: none;
        padding-left: 0;
    }

    .goals-list li {
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-start;
    }

    .goals-list li i {
        color: var(--primary-color);
        margin-right: 0.5rem;
        margin-top: 0.3rem;
    }

    /* CTA Section */
    .cta-section {
        padding: 3rem 0;
        background-color: var(--primary-color);
        color: white;
    }

    .cta-text {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .cta-text span {
        color: var(--secondary-color);
    }

    /* Footer */
    .footer {
        padding: 3rem 0;
        background-color: var(--primary-color);
        color: white;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .footer-logo img {
        height: 40px;
        margin-right: 10px;
    }

    .footer-logo-text {
        font-weight: bold;
        font-size: 1.2rem;
        margin: 0;
        line-height: 1.2;
        color: white;
    }

    .footer-logo-text small {
        font-size: 0.7rem;
        display: block;
    }

    .footer h4 {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: white;
    }

    .footer-links {
        list-style: none;
        padding-left: 0;
    }

    .footer-links li {
        margin-bottom: 0.5rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.3s;
    }

    .footer-links a:hover {
        color: white;
    }

    .footer-contact {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .social-icons {
        display: flex;
        margin-top: 1.5rem;
    }

    .social-icons a {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: 0.5rem;
        transition: background-color 0.3s;
    }

    .social-icons a:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .copyright {
        padding: 1rem 0;
        background-color: var(--secondary-color);
        text-align: center;
        font-size: 0.9rem;
    }

    /* Responsive Styles */
    @media (max-width: 991px) {
        .hero-section {
            padding: 3rem 0;
        }

        .circle-image-container {
            margin-bottom: 2rem;
        }

        .about-image {
            margin-top: 2rem;
        }
    }

    @media (max-width: 767px) {
        .hero-title {
            font-size: 1.8rem;
        }

        .feature-card {
            flex-direction: column;
        }

        .feature-number {
            margin-bottom: 1rem;
            margin-right: 0;
        }

        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
        }

    }

    .slider{
    width: 1300px;
    max-width: 100vw;
    height: 700px;
    margin: auto;
    position: relative;
    overflow: hidden;
    margin-top: 20px; /* Atau sesuai kebutuhan, misal 40px */
}
.slider .list{
    position: absolute;
    width: max-content;
    height: 100%;
    left: 0;
    top: 0;
    display: flex;
    transition: 1s;
}
.slider .list img{
    width: 1300px;
    max-width: 100vw;
    height: 100%;
    object-fit: cover;
}

.slider .item img {
  border-radius: 15px;
}

.slider .buttons{
    position: absolute;
    top: 45%;
    left: 5%;
    width: 90%;
    display: flex;
    justify-content: space-between;
}
.slider .buttons button{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background-color: #fff5;
    color: #fff;
    border: none;
    font-family: monospace;
    font-weight: bold;
    opacity: 0%
}
.slider .dots{
    position: absolute;
    bottom: 10px;
    left: 0;
    color: #fff;
    width: 100%;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
}
.slider .dots li{
    list-style: none;
    width: 10px;
    height: 10px;
    background-color: #fff;
    margin: 10px;
    border-radius: 20px;
    transition: 0.5s;
}
.slider .dots li.active{
    width: 30px;
}
@media screen and (max-width: 768px){
    .slider{
        height: 400px;
    }
}
.slider {
  position: relative;
}

.slider-text {
  position: absolute;
  top: 50%; /* posisi vertikal tengah */
  right: 30px; /* jarak dari kiri */
  transform: translateY(-50%); /* agar benar-benar di tengah vertikal */
  z-index: 10;
  color: white;
  font-size: 24px;
  background-color: rgb(255, 255, 255);
  padding: 10px 20px;
  border-radius: 5px;
  text-align: righ; /* rata kiri */
  max-width: 400px; /* opsional biar nggak terlalu lebar */
}

.slider-text .col-lg-7 {
    max-width: 500px; /* Atau sesuaikan sesuai kebutuhan */
    white-space: normal;
}


</style>
