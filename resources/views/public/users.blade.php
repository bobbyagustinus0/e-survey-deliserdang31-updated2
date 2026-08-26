<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Komentar Pengguna • Ulasan</title>
  <!-- Font & Ikon -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      /* Background dengan gambar gradasi abstrak */
      background: 
        linear-gradient(135deg, rgba(10, 38, 71, 0.85) 0%, rgba(31, 74, 122, 0.70) 100%),
        url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
      background-size: cover, auto;
      background-blend-mode: overlay;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
      position: relative;
    }

    /* Efek ornamen lingkaran dekoratif */
    body::before {
      content: '';
      position: fixed;
      top: -200px;
      right: -200px;
      width: 500px;
      height: 500px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    body::after {
      content: '';
      position: fixed;
      bottom: -150px;
      left: -150px;
      width: 400px;
      height: 400px;
      border-radius: 50%;
      background: radial-gradient(circle, rgba(255,255,255,0.04) 0%, transparent 70%);
      pointer-events: none;
      z-index: 0;
    }

    .container {
      max-width: 960px;
      width: 100%;
      background: rgba(255, 255, 255, 0.88);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-radius: 48px;
      padding: 42px 38px;
      box-shadow: 0 40px 80px -20px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255,255,255,0.8);
      border: 1px solid rgba(255,255,255,0.4);
      transition: all 0.2s;
      position: relative;
      z-index: 1;
    }

    /* ===== TOP BAR ===== */
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 28px;
      flex-wrap: wrap;
      gap: 12px 0;
    }

    .back {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      font-weight: 500;
      color: #1a3a5e;
      background: rgba(255, 255, 255, 0.85);
      padding: 10px 24px;
      border-radius: 60px;
      backdrop-filter: blur(4px);
      border: 1px solid rgba(255,255,255,0.6);
      box-shadow: 0 4px 16px rgba(0,0,0,0.04);
      transition: all 0.25s;
      font-size: 14px;
    }

    .back i {
      font-size: 15px;
      transition: transform 0.25s;
    }

    .back:hover {
      background: white;
      box-shadow: 0 10px 32px rgba(26, 67, 113, 0.18);
      transform: translateY(-2px);
      color: #092135;
    }

    .back:hover i {
      transform: translateX(-5px);
    }

    .btn-login {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      background: linear-gradient(135deg, #0a2647, #1a4a7a);
      color: white;
      padding: 12px 30px;
      border-radius: 60px;
      font-weight: 600;
      font-size: 14px;
      letter-spacing: 0.2px;
      border: 1px solid rgba(255,255,255,0.15);
      box-shadow: 0 10px 28px -8px rgba(10, 38, 71, 0.35);
      transition: all 0.25s;
    }

    .btn-login i {
      font-size: 15px;
    }

    .btn-login:hover {
      background: linear-gradient(135deg, #1a3b63, #2a5a8a);
      transform: translateY(-3px) scale(1.02);
      box-shadow: 0 20px 40px -8px rgba(10, 38, 71, 0.45);
    }

    /* ===== HEADER ===== */
    .header {
      text-align: center;
      margin-bottom: 30px;
      padding: 0 10px;
    }

    .header .icon-wrapper {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background: rgba(10, 38, 71, 0.06);
      border-radius: 80px;
      padding: 10px 24px 10px 18px;
      gap: 12px;
      backdrop-filter: blur(4px);
      border: 1px solid rgba(255,255,255,0.4);
      margin-bottom: 12px;
    }

    .header .icon-wrapper i {
      font-size: 28px;
      color: #1f4a7a;
      opacity: 0.6;
    }

    .header .icon-wrapper span {
      font-size: 14px;
      font-weight: 500;
      color: #1f4a7a;
      letter-spacing: 0.3px;
    }

    .header h1 {
      font-size: 36px;
      font-weight: 700;
      background: linear-gradient(135deg, #0a2647, #2a5a8a);
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      letter-spacing: -0.8px;
      margin-bottom: 6px;
    }

    .header p {
      color: #2c405c;
      font-size: 16px;
      background: rgba(255,255,255,0.6);
      display: inline-block;
      padding: 6px 28px;
      border-radius: 60px;
      backdrop-filter: blur(4px);
      border: 1px solid rgba(255,255,255,0.3);
      font-weight: 450;
      margin-top: 4px;
    }

    .header p i {
      margin-right: 8px;
      color: #1f4a7a;
      opacity: 0.5;
    }

    /* ===== SEARCH ===== */
    .search {
      margin-bottom: 28px;
      position: relative;
    }

    .search i {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: #517499;
      font-size: 16px;
      opacity: 0.6;
      transition: 0.2s;
    }

    .search input {
      width: 100%;
      padding: 17px 22px 17px 52px;
      border: 1px solid rgba(200, 215, 235, 0.5);
      border-radius: 60px;
      font-size: 15px;
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(8px);
      outline: none;
      transition: all 0.3s;
      font-weight: 450;
      color: #0a1e32;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.02);
      font-family: 'Inter', sans-serif;
    }

    .search input::placeholder {
      color: #6a7f99;
      font-weight: 400;
      opacity: 0.7;
    }

    .search input:focus {
      border-color: #1f4a7a;
      background: white;
      box-shadow: 0 12px 36px rgba(26, 67, 113, 0.12);
    }

    .search input:focus ~ i {
      opacity: 0.9;
      color: #1f4a7a;
    }

    /* ===== USER LIST ===== */
    .user-list {
      display: grid;
      gap: 14px;
    }

    .user-card {
      background: rgba(255, 255, 255, 0.85);
      backdrop-filter: blur(6px);
      padding: 18px 24px;
      border-radius: 24px;
      text-decoration: none;
      color: #0a1e32;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border: 1px solid rgba(255, 255, 255, 0.6);
      box-shadow: 0 6px 24px rgba(0, 0, 0, 0.02);
      transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
      position: relative;
      overflow: hidden;
    }

    /* Garis aksen di kiri */
    .user-card::after {
      content: '';
      position: absolute;
      left: 0;
      top: 20%;
      height: 60%;
      width: 4px;
      border-radius: 0 4px 4px 0;
      background: linear-gradient(180deg, #1f4a7a, #5a8ab5);
      opacity: 0;
      transition: all 0.3s;
    }

    a.user-card:hover::after {
      opacity: 1;
      top: 15%;
      height: 70%;
    }

    .user-card::before {
      content: '';
      position: absolute;
      inset: 0;
      border-radius: 24px;
      padding: 1px;
      background: linear-gradient(135deg, rgba(31, 74, 122, 0.08), transparent 60%);
      -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
      -webkit-mask-composite: xor;
      mask-composite: exclude;
      pointer-events: none;
    }

    a.user-card {
      cursor: pointer;
    }

    a.user-card:hover {
      transform: translateY(-5px) scale(1.005);
      background: white;
      border-color: #b6cee8;
      box-shadow: 0 24px 52px -12px rgba(10, 38, 71, 0.22);
    }

    .user-info {
      display: flex;
      flex-direction: column;
      gap: 4px;
      flex: 1;
    }

    .user-info .name-row {
      display: flex;
      align-items: center;
      gap: 12px;
      flex-wrap: wrap;
    }

    .user-info .avatar-icon {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: linear-gradient(135deg, #e9eff6, #d5dfeb);
      display: flex;
      align-items: center;
      justify-content: center;
      color: #1f4a7a;
      font-size: 18px;
      flex-shrink: 0;
      border: 1px solid rgba(255,255,255,0.5);
      transition: all 0.3s;
    }

    a.user-card:hover .avatar-icon {
      background: linear-gradient(135deg, #0a2647, #1f4a7a);
      color: white;
      transform: scale(1.05);
      box-shadow: 0 6px 16px rgba(10, 38, 71, 0.15);
    }

    .user-info h3 {
      font-size: 18px;
      font-weight: 600;
      color: #0a2647;
      letter-spacing: -0.2px;
    }

    .user-info .badge-label {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      background: rgba(10, 38, 71, 0.06);
      padding: 3px 14px 3px 10px;
      border-radius: 60px;
      font-size: 12px;
      font-weight: 500;
      color: #1f4a7a;
      border: 1px solid rgba(255,255,255,0.3);
    }

    .user-info .badge-label i {
      font-size: 11px;
      opacity: 0.7;
    }

    .user-info .sub-info {
      display: flex;
      align-items: center;
      gap: 6px;
      color: #4a6582;
      font-size: 14px;
      margin-top: 2px;
    }

    .user-info .sub-info i {
      font-size: 13px;
      opacity: 0.5;
    }

    .arrow {
      background: rgba(26, 67, 113, 0.05);
      width: 44px;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 60px;
      font-size: 20px;
      color: #1f4a7a;
      transition: all 0.3s;
      border: 1px solid rgba(255,255,255,0.2);
      flex-shrink: 0;
      margin-left: 10px;
    }

    a.user-card:hover .arrow {
      background: linear-gradient(135deg, #0a2647, #1f4a7a);
      color: white;
      transform: translateX(5px) scale(1.05);
      box-shadow: 0 6px 20px rgba(10, 38, 71, 0.2);
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
      background: rgba(255,255,255,0.6);
      backdrop-filter: blur(4px);
      padding: 32px 24px;
      border-radius: 32px;
      text-align: center;
      color: #2c405c;
      border: 1px dashed rgba(31, 74, 122, 0.2);
      font-weight: 450;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
    }

    .empty-state i {
      font-size: 32px;
      color: #1f4a7a;
      opacity: 0.25;
      margin-bottom: 4px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .container {
        padding: 28px 20px;
        border-radius: 32px;
      }

      .header h1 {
        font-size: 28px;
      }

      .header .icon-wrapper {
        padding: 6px 16px 6px 12px;
        font-size: 13px;
      }

      .header .icon-wrapper i {
        font-size: 22px;
      }

      .user-card {
        padding: 16px 18px;
        border-radius: 20px;
      }

      .user-info .avatar-icon {
        width: 38px;
        height: 38px;
        font-size: 15px;
      }

      .user-info h3 {
        font-size: 16px;
      }

      .arrow {
        width: 38px;
        height: 38px;
        font-size: 17px;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 20px 14px;
        border-radius: 24px;
      }

      .top-bar {
        flex-direction: row;
        flex-wrap: wrap;
        gap: 8px;
      }

      .back {
        padding: 8px 14px;
        font-size: 12px;
      }

      .btn-login {
        padding: 8px 16px;
        font-size: 12px;
        gap: 6px;
      }

      .header h1 {
        font-size: 22px;
      }

      .header p {
        font-size: 13px;
        padding: 4px 14px;
      }

      .search input {
        padding: 14px 16px 14px 44px;
        font-size: 14px;
      }

      .search i {
        left: 16px;
        font-size: 14px;
      }

      .user-card {
        padding: 14px 14px;
        border-radius: 18px;
        flex-wrap: wrap;
        gap: 8px;
      }

      .user-info h3 {
        font-size: 14px;
      }

      .user-info .sub-info {
        font-size: 12px;
      }

      .user-info .badge-label {
        font-size: 10px;
        padding: 2px 10px 2px 8px;
      }

      .user-info .avatar-icon {
        width: 34px;
        height: 34px;
        font-size: 13px;
      }

      .arrow {
        width: 32px;
        height: 32px;
        font-size: 14px;
      }

      .header .icon-wrapper {
        padding: 4px 12px 4px 10px;
        font-size: 11px;
      }

      .header .icon-wrapper i {
        font-size: 18px;
      }
    }

    /* ===== ANIMASI ===== */
    .user-item {
      animation: slideFade 0.45s ease forwards;
      opacity: 0;
    }

    @keyframes slideFade {
      0% { opacity: 0; transform: translateY(16px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .user-item:nth-child(1) { animation-delay: 0.02s; }
    .user-item:nth-child(2) { animation-delay: 0.07s; }
    .user-item:nth-child(3) { animation-delay: 0.12s; }
    .user-item:nth-child(4) { animation-delay: 0.17s; }
    .user-item:nth-child(5) { animation-delay: 0.22s; }
    .user-item:nth-child(6) { animation-delay: 0.27s; }
  </style>
</head>
<body>

<div class="container">

  <!-- ===== TOP BAR ===== -->
  <div class="top-bar">
    <a href="{{ route('welcome') }}" class="back">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
    <a href="{{ route('login') }}" class="btn-login">
      <i class="fas fa-lock"></i> Login
    </a>
  </div>

  <!-- ===== HEADER ===== -->
  <div class="header">
    <div class="icon-wrapper">
      <i class="fas fa-comment-dots"></i>
      <span>KOMUNITAS</span>
    </div>
    <h1>Komentar Pengguna</h1>
    <p><i class="fas fa-users"></i> Tanggapan & ulasan layanan digital</p>
  </div>

  <!-- ===== SEARCH ===== -->
  <div class="search">
    <input type="text" id="searchUser" placeholder="Cari nama pengguna ...">
    <i class="fas fa-search"></i>
  </div>

  <!-- ===== USER LIST ===== -->
  <div class="user-list" id="userList">

    @forelse($users as $user)
      <a href="{{ route('public.user.comments', $user->id) }}" class="user-card user-item">
        <div class="user-info">
          <div class="name-row">
            <div class="avatar-icon">
              <i class="fas fa-user"></i>
            </div>
            <h3>{{ $user->name }}</h3>
            <span class="badge-label">
              <i class="fas fa-shield-alt"></i> Pengguna
            </span>
          </div>
          <div class="sub-info">
            <i class="fas fa-message"></i> Lihat komentar survei
          </div>
        </div>
        <div class="arrow">
          <i class="fas fa-chevron-right"></i>
        </div>
      </a>
    @empty
      <div class="user-card empty-state" style="justify-content: center; gap: 10px; flex-wrap: wrap; cursor: default;">
        <i class="fas fa-user-slash"></i>
        <span>Belum ada pengguna.</span>
      </div>
    @endforelse

  </div>
</div>

<!-- ===== SEARCH SCRIPT ===== -->
<script>
  (function() {
    const search = document.getElementById('searchUser');
    const items = document.querySelectorAll('.user-item');

    search.addEventListener('input', function() {
      const keyword = this.value.toLowerCase().trim();

      items.forEach(function(item) {
        const nameEl = item.querySelector('h3');
        if (!nameEl) return;
        const name = nameEl.textContent.toLowerCase();
        const match = name.includes(keyword);
        item.style.display = match ? 'flex' : 'none';
        if (match) {
          item.style.animation = 'slideFade 0.3s ease forwards';
        }
      });
    });
  })();
</script>

</body>
</html>