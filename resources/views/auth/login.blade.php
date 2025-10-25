@extends('layouts.app')

@section('title', 'Login - Sistem Penjadwalan Otomatis')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
/* Background hitam dengan efek fire */
html, body {
    position: absolute;
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: linear-gradient(180deg, #1a0000 0%, #000000 50%, #1a0a00 100%);
    touch-action: none;
}

/* SVG latar belakang dengan warna hitam */
svg#svg-bg {
    position: absolute;
    width: 100%;
    height: 100%;
    background: #000000;
    cursor: pointer;
    filter: drop-shadow(0 0 20px rgba(255, 100, 0, 0.5));
    top: 0;
    left: 0;
    z-index: 0;
}

/* Lapisan overlay untuk form login agar di atas SVG */
.overlay-login {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    box-sizing: border-box;
}

/* Kartu login dengan tema fire */
.card-login {
    background: rgba(20, 20, 20, 0.95);
    border-radius: 12px;
    border: 2px solid rgba(255, 100, 0, 0.3);
    box-shadow: 0 6px 30px rgba(255, 69, 0, 0.4), 0 0 40px rgba(255, 100, 0, 0.2);
    max-width: 380px;
    width: 100%;
    pointer-events: auto;
}

/* Konten kartu */
.card-login .card-body {
    padding: 20px;
}

/* Logo */
.logo-img {
    width: 60px;
    height: auto;
    margin-bottom: 0.5rem;
    filter: drop-shadow(0 0 10px rgba(255, 100, 0, 0.6));
}

/* Judul dengan warna fire */
.card-login h5 {
    color: #ff6600;
    text-shadow: 0 0 10px rgba(255, 100, 0, 0.5);
    font-size: 1.25rem;
    margin-bottom: 0.75rem;
}

/* Label */
.form-label {
    font-weight: 600;
    margin-bottom: 0.3rem;
    font-size: 0.875rem;
    color: #ffaa66;
}

/* Input dengan tema dark fire */
.form-control {
    width: 100%;
    padding: 0.625rem 2rem 0.625rem 0.75rem;
    border: 1px solid rgba(255, 100, 0, 0.3);
    border-radius: 8px;
    font-size: 0.9rem;
    background: rgba(40, 20, 10, 0.8);
    color: #ffcc99;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #ff6600;
    box-shadow: 0 0 0 3px rgba(255, 100, 0, 0.3);
    background: rgba(50, 25, 10, 0.9);
}

/* Toggle password */
.password-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    border: none;
    background: none;
    cursor: pointer;
    padding: 5px 10px;
    color: #ff8844;
    z-index: 10;
    font-size: 1rem;
}

.password-toggle:hover { 
    color: #ff6600;
}

/* Link lupa password */
.forgot-password {
    color: #ff8844;
    text-decoration: none;
}

.forgot-password:hover {
    color: #ff6600;
    text-decoration: underline;
}

.text-end small {
    color: #ffaa66;
    font-size: 0.8rem;
}

/* Tombol Login dengan gradient fire */
.btn-primary {
    background: linear-gradient(135deg, #ff4500 0%, #ff6600 50%, #ff8800 100%);
    border: none;
    padding: 0.625rem 1rem;
    font-weight: 600;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(255, 69, 0, 0.4);
    color: #fff;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #ff6600 0%, #ff8800 50%, #ffaa00 100%);
    box-shadow: 0 5px 18px rgba(255, 100, 0, 0.5);
}

/* HR divider */
hr {
    border-color: rgba(255, 100, 0, 0.3);
}

/* Alert demo account dengan tema fire */
.alert-info {
    font-size: 0.75rem;
    padding: 0.65rem 0.85rem;
    border-radius: 8px;
    background: rgba(50, 25, 10, 0.6);
    border: 1px solid rgba(255, 100, 0, 0.3);
    color: #ffcc99;
}

.alert-info .fw-bold {
    color: #ff8844;
    font-size: 0.8rem;
}

.alert-info strong {
    color: #ffaa66;
}

/* Invalid feedback */
.invalid-feedback {
    color: #ff3333;
}

/* Demo Toggle Button */
.btn-demo-toggle {
    background: linear-gradient(135deg, rgba(255, 100, 0, 0.2) 0%, rgba(255, 69, 0, 0.3) 100%);
    border: 1px solid rgba(255, 100, 0, 0.4);
    color: #ff8844;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    width: 100%;
    font-size: 0.875rem;
}

.btn-demo-toggle:hover {
    background: linear-gradient(135deg, rgba(255, 100, 0, 0.3) 0%, rgba(255, 69, 0, 0.4) 100%);
    border-color: rgba(255, 100, 0, 0.6);
    box-shadow: 0 2px 8px rgba(255, 100, 0, 0.25);
}

.btn-demo-toggle i.fa-chevron-down {
    transition: transform 0.3s ease;
}

.btn-demo-toggle.active i.fa-chevron-down {
    transform: rotate(180deg);
}

/* Demo Accounts Container */
.demo-accounts-container {
    animation: slideDown 0.4s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Demo Card */
.demo-card {
    background: linear-gradient(135deg, rgba(30, 15, 10, 0.9) 0%, rgba(20, 10, 5, 0.95) 100%);
    border: 1px solid rgba(255, 100, 0, 0.3);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(255, 69, 0, 0.2);
}

/* Demo Header */
.demo-header {
    background: linear-gradient(135deg, rgba(255, 69, 0, 0.3) 0%, rgba(255, 100, 0, 0.2) 100%);
    padding: 0.65rem 0.85rem;
    border-bottom: 1px solid rgba(255, 100, 0, 0.3);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #ff8844;
    font-weight: 600;
    font-size: 0.875rem;
}

.demo-header i {
    font-size: 1rem;
}

/* Demo Body */
.demo-body {
    padding: 0.5rem;
    max-height: 280px;
    overflow-y: auto;
}

/* Custom Scrollbar */
.demo-body::-webkit-scrollbar {
    width: 6px;
}

.demo-body::-webkit-scrollbar-track {
    background: rgba(255, 100, 0, 0.1);
    border-radius: 10px;
}

.demo-body::-webkit-scrollbar-thumb {
    background: rgba(255, 100, 0, 0.4);
    border-radius: 10px;
}

.demo-body::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 100, 0, 0.6);
}

/* Demo Item */
.demo-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.6rem;
    margin-bottom: 0.4rem;
    background: rgba(40, 20, 10, 0.5);
    border: 1px solid rgba(255, 100, 0, 0.2);
    border-radius: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.demo-item:hover {
    background: rgba(50, 25, 10, 0.7);
    border-color: rgba(255, 100, 0, 0.4);
    box-shadow: 0 2px 8px rgba(255, 100, 0, 0.15);
}

.demo-item:last-child {
    margin-bottom: 0;
}

/* Demo Role */
.demo-role {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    color: #ff8844;
    min-width: 90px;
}

.demo-role i {
    font-size: 0.95rem;
    color: #ff6600;
}

.demo-role strong {
    font-size: 0.8rem;
}

/* Demo Credentials */
.demo-credentials {
    flex: 1;
    text-align: center;
    color: #ffaa66;
    font-size: 0.75rem;
}

.demo-credentials code {
    background: rgba(255, 100, 0, 0.15);
    padding: 0.15rem 0.4rem;
    border-radius: 4px;
    color: #ffcc99;
    font-family: 'Courier New', monospace;
    border: 1px solid rgba(255, 100, 0, 0.2);
    font-size: 0.75rem;
}

/* Copy Button */
.btn-copy {
    background: linear-gradient(135deg, #ff4500 0%, #ff6600 100%);
    border: none;
    color: #fff;
    padding: 0.35rem 0.6rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.8rem;
}

.btn-copy:hover {
    background: linear-gradient(135deg, #ff6600 0%, #ff8800 100%);
    box-shadow: 0 2px 8px rgba(255, 100, 0, 0.4);
}

.btn-copy:active {
    transform: scale(0.98);
}

.btn-copy.copied {
    background: linear-gradient(135deg, #00cc66 0%, #00aa55 100%);
}

.btn-copy.copied i:before {
    content: "\f00c";
}

/* Responsive */
@media (max-width: 576px) {
    .demo-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .demo-credentials {
        text-align: left;
        width: 100%;
    }
    
    .btn-copy {
        align-self: flex-end;
    }
}
</style>

<!-- SVG latar belakang dengan gradient fire -->
<svg id="svg-bg" aria-hidden="true">
  <defs>
    <!-- Gradient untuk kepala naga - warna api -->
    <linearGradient id="fireGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#ffaa00;stop-opacity:1" />
      <stop offset="50%" style="stop-color:#ff6600;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#ff3300;stop-opacity:1" />
    </linearGradient>
    
    <!-- Gradient untuk outline - warna api gelap -->
    <linearGradient id="fireGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#cc4400;stop-opacity:1" />
      <stop offset="50%" style="stop-color:#aa2200;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#880000;stop-opacity:1" />
    </linearGradient>
    
    <g id="Cabeza" transform="matrix(1, 0, 0, 1, 0, 0)">
      <path style="fill:url(#fireGrad1)" d="M-28.9,-1.1L-28.55 -1.95Q-28.1 -3.1 -27.25 -2.95L-26.7 -2.95Q-27.7 -1.65 -28.9 -1.1M-18.35,-1.8Q-15.1 -10.3 -9.6 -6.05Q-15.1 -6.2 -18.35 -1.8M-18.35,1.1Q-15.1 5.45 -9.6 5.35Q-15.1 9.55 -18.35 1.1M-26.7,2.2L-27.25 2.25Q-28.1 2.4 -28.55 1.2L-28.9 0.35Q-27.7 0.9 -26.7 2.2" />
      <path style="fill:url(#fireGrad2)" d="M-21.05,-8.25Q-13.6 -15.95 -1.3 -12.1Q-7.85 -8.5 -5.85 -4.35Q-2.3 -4.85 10.5 0.15Q0 4.35 -5.85 3.65Q-7.85 7.75 -1.25 12.45Q-13.6 15.2 -21.05 7.5Q-29.55 4.05 -30.2 -0.35Q-29.55 -4.8 -21.05 -8.25M-26.7,-2.95L-27.25 -2.95Q-28.1 -3.1 -28.55 -1.95L-28.9 -1.1Q-27.7 -1.65 -26.7 -2.95M-9.6,-6.05Q-15.1 -10.3 -18.35 -1.8Q-15.1 -6.2 -9.6 -6.05M-9.6,5.35Q-15.1 5.45 -18.35 1.1Q-15.1 9.55 -9.6 5.35M-28.9,0.35L-28.55 1.2Q-28.1 2.4 -27.25 2.25L-26.7 2.2Q-27.7 0.9 -28.9 0.35" />
    </g>
    <g id="Aletas" transform="matrix(1, 0, 0, 1, 0, 0)">
      <linearGradient id="LinearGradID_1" gradientUnits="userSpaceOnUse" gradientTransform="matrix(0.0935974, 0, 0, 0.188782, -20.55, 0)" spreadMethod="pad" x1="-819.2" y1="0" x2="819.2" y2="0">
        <stop offset="0" style="stop-color:#ff8800;stop-opacity:1" />
        <stop offset="1" style="stop-color:#cc3300;stop-opacity:1" />
      </linearGradient>
      <path style="fill:url(#LinearGradID_1) " d="M29.75,-36.85Q-17.75 -61.45 -42.05 -40.95L-45.35 -38.35L-53.7 -41.15L-51.15 -44.85Q-34.85 -68.4 21 -57.8Q-32.2 -72.1 -50.25 -50Q-53.85 -45.65 -56.05 -41.95L-64.7 -43.35L-60.6 -50.3Q-45.9 -75.55 5.1 -79.35Q-2.2 -79.8 -9.45 -79.15Q-16.2 -78.55 -22.85 -77.15Q-29.85 -75.65 -36.5 -73Q-43.05 -70.4 -48.8 -66.85Q-54.55 -63.35 -56.8 -60.3L-60.5 -55.4Q-62.95 -52.1 -67 -43.55L-70.55 -43.55L-76.35 -42.95Q-74.6 -49.1 -71.85 -54.85Q-68.9 -61.25 -64.8 -67.1Q-60.8 -73 -55.45 -77.55Q-49.9 -82.35 -43.65 -85.85L-30.6 -92.7Q-24.05 -95.95 -17 -98.25Q-63.75 -86.35 -73.65 -57.1Q-75.75 -50.75 -77.45 -42.75Q-82.9 -41.75 -88 -39.65Q-87.65 -46.65 -86.3 -53.05Q-79.8 -89.8 -36.65 -117.2Q-80.65 -94.5 -87.55 -59.55Q-88.65 -54.15 -88.95 -39.4L-89.8 -38.85L-92.7 -37.6Q-93.75 -44.35 -94.1 -51.15Q-94.4 -58.2 -93.25 -65.1Q-92.15 -72.5 -90.05 -79.65Q-88.05 -86.55 -85 -93Q-82.1 -99.3 -78.45 -105.15Q-74.6 -111.35 -70.25 -117.25Q-65.95 -123.1 -61.1 -128.55Q-70.3 -119.35 -77.9 -108.7Q-86 -97.3 -90.8 -84.05Q-95.8 -70.5 -96 -56.15Q-96.1 -46 -94.05 -36.05L-93.25 -31.55Q-93.5 -35.65 -92.35 -36Q-79.85 -42 -66.6 -40.45Q-52.45 -38.85 -39.2 -33.25Q-28.3 -29.9 -21.25 -24.15Q-17.8 -23.3 -8.6 -15.6Q-12.1 -20.75 -16.75 -24.5Q-24.55 -30.7 -34.25 -34.05L-42.55 -37Q-38.9 -41.25 -31.5 -43.25Q-24.05 -45.3 -16.2 -46.3Q-8.35 -47.35 -1 -46Q5.95 -44.75 12.75 -42.85Q19.85 -40.9 29.75 -36.85M-92.45,-27.35L-94.95 -36.25Q-109.7 -105 -27.95 -154.65Q-98.65 -103.8 -91.75 -39.4L-89.95 -40.2Q-92.2 -105.25 -5.6 -130.9Q-78.8 -99.95 -87.45 -40.9Q-83.15 -42.95 -78.45 -43.95Q-70 -101.3 17.65 -103.8Q-56.9 -93.4 -74.5 -44.55L-67.4 -45.45Q-49.1 -94.95 39.25 -75.65Q-36.75 -84.35 -62.25 -44.25L-57.3 -43.6Q-31.65 -86.5 56.15 -46.05Q-20.3 -73.35 -51.35 -41.7L-45.95 -39.75Q-17.85 -71.35 51.85 -24.8Q-8.7 -56.4 -39.75 -37.05Q-28.15 -34.05 -14.25 -24.45Q-8.6 -19.85 -5.8 -16.95Q5.95 -2.4 20 0Q5.95 2.4 -5.8 16.95Q-8.6 19.85 -14.25 24.45Q-28.15 34.05 -39.75 37.05Q-8.7 56.4 51.85 24.8Q-17.85 71.35 -45.95 39.75L-51.35 41.7Q-20.3 73.35 56.15 46.1Q-31.65 86.5 -57.3 43.65L-62.25 44.3Q-36.75 84.35 39.25 75.7Q-49.1 94.95 -67.4 45.5L-74.5 44.6Q-56.9 93.4 17.65 103.85Q-70 101.3 -78.45 43.95Q-83.15 42.95 -87.45 40.9Q-78.8 99.95 -5.6 130.9Q-92.2 105.25 -89.95 40.25L-91.75 39.4Q-98.65 103.8 -27.95 154.65Q-109.7 105 -94.95 36.3L-92.45 27.35Q-93.05 33.9 -92.05 34.75Q-91.1 35.55 -88.95 36.7L-87.95 37Q-83.7 38.25 -79.05 38.8L-77.25 38.95Q-72.55 39.3 -67.5 38.85L-65.45 38.65Q-44.4 36.05 -17.8 19.6Q-9.9 12.8 -15.15 4.4Q-18.15 3.15 -19 0Q-18.15 -3.15 -15.15 -4.4Q-9.9 -12.8 -17.8 -19.6L-17.8 -19.55Q-44.4 -36.05 -65.45 -38.6L-67.5 -38.8Q-72.55 -39.3 -77.25 -38.95L-79.05 -38.75Q-83.7 -38.25 -87.95 -36.95L-88.95 -36.65Q-91.1 -35.55 -92.05 -34.7Q-93.05 -33.9 -92.45 -27.35M-8.6,15.6Q-17.8 23.3 -21.25 24.2Q-28.3 29.9 -39.2 33.3Q-52.45 38.85 -66.6 40.5Q-79.85 42 -92.35 36Q-93.5 35.65 -93.25 31.55L-94.05 36.1Q-96.1 46.05 -96 56.15Q-95.8 70.5 -90.8 84.1Q-86 97.3 -77.9 108.75Q-70.3 119.35 -61.1 128.6Q-65.95 123.1 -70.25 117.25Q-74.6 111.35 -78.45 105.15Q-82.1 99.3 -85 93Q-88.05 86.55 -90.05 79.7Q-92.15 72.5 -93.25 65.1Q-94.4 58.2 -94.1 51.2Q-93.75 44.35 -92.7 37.6L-89.8 38.9L-88.95 39.45Q-88.65 54.15 -87.55 59.55Q-80.65 94.5 -36.65 117.25Q-79.8 89.8 -86.3 53.1Q-87.65 46.65 -88 39.65Q-82.9 41.75 -77.45 42.75Q-75.75 50.75 -73.65 57.15Q-63.75 86.35 -17 98.3Q-24.05 95.95 -30.6 92.75L-43.65 85.9Q-49.9 82.35 -55.45 77.6Q-60.8 73 -64.8 67.15Q-68.9 61.25 -71.85 54.85Q-74.6 49.1 -76.35 42.95L-70.55 43.6L-67 43.6Q-62.95 52.1 -60.5 55.4L-56.8 60.35Q-54.55 63.35 -48.8 66.9Q-43.05 70.4 -36.5 73Q-29.85 75.65 -22.85 77.15Q-16.2 78.55 -9.45 79.15Q-2.2 79.8 5.1 79.35Q-45.9 75.55 -60.6 50.3L-64.7 43.4L-56.05 41.95Q-53.85 45.65 -50.25 50Q-32.2 72.1 21 57.85Q-34.85 68.4 -51.15 44.85L-53.7 41.2L-45.35 38.35L-42.05 40.95Q-17.75 61.45 29.75 36.85Q19.85 40.9 12.75 42.9Q5.95 44.75 -1 46Q-8.35 47.35 -16.2 46.35Q-24.05 45.3 -31.5 43.3Q-38.9 41.25 -42.55 37.05L-34.25 34.05Q-24.55 30.7 -16.75 24.5Q-12.1 20.75 -8.6 15.6" />
    </g>
    <g id="Espina" transform="matrix(1, 0, 0, 1, 0, 0)">
      <linearGradient id="LinearGradID_2" gradientUnits="userSpaceOnUse" gradientTransform="matrix(0.0229492, 0, 0, -0.0152893, 0, 0.05)" spreadMethod="pad" x1="-819.2" y1="0" x2="819.2" y2="0">
        <stop offset="0" style="stop-color:#ffaa00;stop-opacity:1" />
        <stop offset="1" style="stop-color:#dd4400;stop-opacity:1" />
      </linearGradient>
      <path style="fill:url(#LinearGradID_2) " d="M-18.8,0Q-17.85 -5.7 -12.3 -9.6Q-11.2 -5.35 -6.5 -8.25L-6.45 -8.2L-6.2 -8.3Q1.25 -16.25 6.65 -12.4Q0.05 -12.55 0 -5.95Q2.7 -2.4 7.75 -4.1Q18 -1.45 18.8 0L-18.8 0" />
      <linearGradient id="LinearGradID_3" gradientUnits="userSpaceOnUse" gradientTransform="matrix(0.0229492, 0, 0, 0.0152893, 0, -0.05)" spreadMethod="pad" x1="-819.2" y1="0" x2="819.2" y2="0">
        <stop offset="0" style="stop-color:#ffaa00;stop-opacity:1" />
        <stop offset="1" style="stop-color:#dd4400;stop-opacity:1" />
      </linearGradient>
      <path style="fill:url(#LinearGradID_3) " d="M18.8,0Q18 1.45 7.75 4.1Q2.7 2.4 0 5.95Q0.05 12.55 6.65 12.4Q1.25 16.25 -6.2 8.35Q-6.35 8.25 -6.45 8.25L-6.5 8.25Q-11.2 5.35 -12.3 9.6Q-17.85 5.7 -18.8 0L18.8 0" />
    </g>
  </defs>
  <g id="screen"></g>
</svg>

<!-- Overlay form login -->
<div class="overlay-login">
    <div class="card card-login">
        <div class="card-body">
            <div class="text-center mb-3">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="logo-img">
                <h5 class="mb-0 fw-semibold">Sistem Penjadwalan Otomatis</h5>
            </div>

            <form method="POST" action="{{ route('login.proses') }}">
                @csrf

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            class="form-control @error('username') is-invalid @enderror"
                            id="username" 
                            name="username" 
                            value="{{ old('username') }}"
                            required
                            autocomplete="username"
                        >
                    </div>
                    @error('username')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Tampilkan/Sembunyikan Password">
                            <i class="fa-solid fa-eye" id="eyeIcon" aria-hidden="true"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="text-end mb-3">
                    <small>
                        Lupa password? <a href="#" class="forgot-password" id="contactAdmin">Hubungi admin</a>
                    </small>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-right-to-bracket me-2"></i> Login
                    </button>
                </div>
            </form>

            <hr class="my-4">
            
            <!-- Button untuk toggle demo accounts -->
            <div class="text-center mb-3">
                <button type="button" class="btn-demo-toggle" id="toggleDemo">
                    <i class="fa-solid fa-key me-2"></i>
                    Lihat Akun Demo
                    <i class="fa-solid fa-chevron-down ms-2" id="chevronIcon"></i>
                </button>
            </div>

            <!-- Demo accounts container (hidden by default) -->
            <div class="demo-accounts-container" id="demoAccounts" style="display: none;">
                <div class="demo-card">
                    <div class="demo-header">
                        <i class="fa-solid fa-user-shield"></i>
                        <span>Akun Demo Tersedia</span>
                    </div>
                    <div class="demo-body">
                        <div class="demo-item" data-username="dekan123" data-password="dekan123">
                            <div class="demo-role">
                                <i class="fa-solid fa-crown"></i>
                                <strong>Dekan</strong>
                            </div>
                            <div class="demo-credentials">
                                <code>dekan123</code> / <code>dekan123</code>
                            </div>
                            <button class="btn-copy" title="Salin & Login">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>

                        <div class="demo-item" data-username="kaprodi123" data-password="kaprodi123">
                            <div class="demo-role">
                                <i class="fa-solid fa-user-tie"></i>
                                <strong>Kaprodi</strong>
                            </div>
                            <div class="demo-credentials">
                                <code>kaprodi123</code> / <code>kaprodi123</code>
                            </div>
                            <button class="btn-copy" title="Salin & Login">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>

                        <div class="demo-item" data-username="dosen123" data-password="dosen123">
                            <div class="demo-role">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <strong>Dosen</strong>
                            </div>
                            <div class="demo-credentials">
                                <code>dosen123</code> / <code>dosen123</code>
                            </div>
                            <button class="btn-copy" title="Salin & Login">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>

                        <div class="demo-item" data-username="dosen1234" data-password="dosen1234">
                            <div class="demo-role">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <strong>Dosen 2</strong>
                            </div>
                            <div class="demo-credentials">
                                <code>dosen1234</code> / <code>dosen1234</code>
                            </div>
                            <button class="btn-copy" title="Salin & Login">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>

                        <div class="demo-item" data-username="dosen12345" data-password="dosen12345">
                            <div class="demo-role">
                                <i class="fa-solid fa-chalkboard-user"></i>
                                <strong>Dosen 3</strong>
                            </div>
                            <div class="demo-credentials">
                                <code>dosen12345</code> / <code>dosen12345</code>
                            </div>
                            <button class="btn-copy" title="Salin & Login">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>

                        <div class="demo-item" data-username="kosma123" data-password="kosma123">
                            <div class="demo-role">
                                <i class="fa-solid fa-users"></i>
                                <strong>KOSMA</strong>
                            </div>
                            <div class="demo-credentials">
                                <code>kosma123</code> / <code>kosma123</code>
                            </div>
                            <button class="btn-copy" title="Salin & Login">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>

                        <div class="demo-item" data-username="mahasiswa123" data-password="mahasiswa123">
                            <div class="demo-role">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <strong>Mahasiswa</strong>
                            </div>
                            <div class="demo-credentials">
                                <code>mahasiswa123</code> / <code>mahasiswa123</code>
                            </div>
                            <button class="btn-copy" title="Salin & Login">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>

                        <div class="demo-item" data-username="sekprodi123" data-password="sekprodi123">
                            <div class="demo-role">
                                <i class="fa-solid fa-user-gear"></i>
                                <strong>Sekprodi</strong>
                            </div>
                            <div class="demo-credentials">
                                <code>sekprodi123</code> / <code>sekprodi123</code>
                            </div>
                            <button class="btn-copy" title="Salin & Login">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script efek latar -->
<script>
"use strict";

const screen = document.getElementById("screen");
const xmlns = "http://www.w3.org/2000/svg";
const xlinkns = "http://www.w3.org/1999/xlink";

window.addEventListener(
  "pointermove",
  (e) => {
    pointer.x = e.clientX;
    pointer.y = e.clientY;
    rad = 0;
  },
  false
);

const resize = () => {
  width = window.innerWidth;
  height = window.innerHeight;
};

let width, height;
window.addEventListener("resize", () => resize(), false);
resize();

const prepend = (use, i) => {
  const elem = document.createElementNS(xmlns, "use");
  elems[i].use = elem;
  elem.setAttributeNS(xlinkns, "xlink:href", "#" + use);
  screen.prepend(elem);
};

const N = 40;

const elems = [];
for (let i = 0; i < N; i++) elems[i] = { use: null, x: width / 2, y: 0 };
const pointer = { x: width / 2, y: height / 2 };
const radm = Math.min(pointer.x, pointer.y) - 20;
let frm = Math.random();
let rad = 0;

for (let i = 1; i < N; i++) {
  if (i === 1) prepend("Cabeza", i);
  else if (i === 8 || i === 14) prepend("Aletas", i);
  else prepend("Espina", i);
}

const run = () => {
  requestAnimationFrame(run);
  let e = elems[0];
  const ax = (Math.cos(3 * frm) * rad * width) / height;
  const ay = (Math.sin(4 * frm) * rad * height) / width;
  e.x += (ax + pointer.x - e.x) / 10;
  e.y += (ay + pointer.y - e.y) / 10;
  for (let i = 1; i < N; i++) {
    let e = elems[i];
    let ep = elems[i - 1];
    const a = Math.atan2(e.y - ep.y, e.x - ep.x);
    e.x += (ep.x - e.x + (Math.cos(a) * (100 - i)) / 5) / 4;
    e.y += (ep.y - e.y + (Math.sin(a) * (100 - i)) / 5) / 4;
    const s = (162 + 4 * (1 - i)) / 50;
    e.use.setAttributeNS(
      null,
      "transform",
      `translate(${(ep.x + e.x) / 2},${(ep.y + e.y) / 2}) rotate(${(180 / Math.PI) * a}) translate(0,0) scale(${s},${s})`
    );
  }
  if (rad < radm) rad++;
  frm += 0.003;
  if (rad > 60) {
    pointer.x += (width / 2 - pointer.x) * 0.05;
    pointer.y += (height / 2 - pointer.y) * 0.05;
  }
};

run();
</script>

@push('scripts')
<script>
// Script util: toggle password & kontak admin
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const contactAdmin = document.getElementById('contactAdmin');
    const toggleDemo = document.getElementById('toggleDemo');
    const demoAccounts = document.getElementById('demoAccounts');
    const chevronIcon = document.getElementById('chevronIcon');

    // Toggle Password Visibility
    if (togglePassword && passwordInput && eyeIcon) {
        togglePassword.addEventListener('click', function(e) {
            e.preventDefault();
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            if (type === 'password') {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            } else {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            }
        });
    }

    // Contact Admin
    if (contactAdmin) {
        contactAdmin.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Silakan hubungi admin melalui:\n\n📧 Email: muhammadnurjaman50@gmail.com\n📱 WhatsApp: 081224625130\n\nAtau kunjungi ruangan admin di Garut');
        });
    }

    // Toggle Demo Accounts
    if (toggleDemo && demoAccounts) {
        toggleDemo.addEventListener('click', function() {
            if (demoAccounts.style.display === 'none') {
                demoAccounts.style.display = 'block';
                toggleDemo.classList.add('active');
            } else {
                demoAccounts.style.display = 'none';
                toggleDemo.classList.remove('active');
            }
        });
    }

    // Copy & Auto-fill Demo Credentials
    const demoItems = document.querySelectorAll('.demo-item');
    const usernameInput = document.getElementById('username');
    
    demoItems.forEach(item => {
        const copyBtn = item.querySelector('.btn-copy');
        const username = item.dataset.username;
        const password = item.dataset.password;
        
        // Click on demo item or copy button
        const handleClick = (e) => {
            e.stopPropagation();
            
            // Fill the form
            if (usernameInput && passwordInput) {
                usernameInput.value = username;
                passwordInput.value = password;
                
                // Visual feedback
                copyBtn.classList.add('copied');
                const originalIcon = copyBtn.querySelector('i');
                
                setTimeout(() => {
                    copyBtn.classList.remove('copied');
                }, 1500);
                
                // Show notification
                showNotification('Kredensial berhasil disalin!', 'success');
            }
        };
        
        item.addEventListener('click', handleClick);
        if (copyBtn) {
            copyBtn.addEventListener('click', handleClick);
        }
    });

    // Notification Function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `custom-notification ${type}`;
        notification.innerHTML = `
            <i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Trigger animation
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Add notification styles dynamically
    const notifStyle = document.createElement('style');
    notifStyle.textContent = `
        .custom-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, rgba(30, 15, 10, 0.95) 0%, rgba(20, 10, 5, 0.98) 100%);
            border: 2px solid rgba(255, 100, 0, 0.5);
            color: #ffcc99;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(255, 69, 0, 0.4);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            z-index: 10000;
            opacity: 0;
            transform: translateX(400px);
            transition: all 0.3s ease;
            font-weight: 600;
        }
        
        .custom-notification.show {
            opacity: 1;
            transform: translateX(0);
        }
        
        .custom-notification.success {
            border-color: rgba(0, 200, 100, 0.5);
        }
        
        .custom-notification.success i {
            color: #00cc66;
            font-size: 1.3rem;
        }
        
        .custom-notification i {
            font-size: 1.3rem;
            color: #ff6600;
        }
        
        @media (max-width: 576px) {
            .custom-notification {
                right: 10px;
                left: 10px;
                top: 10px;
            }
        }
    `;
    document.head.appendChild(notifStyle);
});
</script>
@endpush

@endsection