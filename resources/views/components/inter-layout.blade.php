<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Account Settings | Laravel Practice</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

<div class="layout">
  <aside class="sidebar" aria-label="Sidebar">
    <div class="logo"><div class="logo-mark" aria-hidden="true"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.2"><path d="M12 2 3 6v6c0 5.2 3.5 8.2 9 10 5.5-1.8 9-4.8 9-10V6L12 2Z"/><path d="m8.7 12 2.1 2.1 4.6-4.6"/></svg></div><div><div class="logo-name">Gatekeeper</div><div class="logo-note">ADMIN WORKSPACE</div></div></div>
    <div class="nav-caption">Workspace</div>
    <div class="nav-link current"><span class="nav-icon">▧</span> Roles &amp; Permissions</div>
    <div class="sidebar-bottom"><div class="sidebar-status"><strong><span class="status-dot">●</span> Access control</strong><p>Review the configured permissions for each role.</p></div><div class="profile"><div class="profile-icon">AD</div><div><strong>Admin User</strong><small>Administrator</small></div></div></div>
  </aside>
  <main class="main" id="roles">
    {{ $slot }}
  </main>


</div>

</body>
</html>