(() => {
  // Cache common DOM nodes used across handlers.
  const navbar = document.querySelector('.header .header-2 .navbar');
  const userBox = document.querySelector('.header .header-2 .user-box');
  const header2 = document.querySelector('.header .header-2');
  const menuBtn = document.querySelector('#menu-btn');
  const userBtn = document.querySelector('#user-btn');

  // Close any open dropdowns when the user scrolls.
  const closeOnScroll = () => {
    if (navbar) navbar.classList.remove('active');
    if (userBox) userBox.classList.remove('active');
  };

  // Add sticky class to header once the page is scrolled a bit.
  const stickyHeaderOnScroll = () => {
    if (!header2) return;
    if (window.scrollY > 80) {
      header2.classList.add('active');
    } else {
      header2.classList.remove('active');
    }
  };

  // Remove flash messages automatically or when the close icon is clicked.
  const autoDismissMessages = (timeout = 4000) => {
    document.querySelectorAll('.message').forEach((message) => {
      const closeBtn = message.querySelector('.fa-times');
      if (closeBtn) {
        closeBtn.addEventListener('click', () => message.remove());
      }
      if (timeout > 0) {
        setTimeout(() => message.remove(), timeout);
      }
    });
  };

  // Toggle the main navigation on mobile.
  const toggleMenu = () => {
    if (!navbar) return;
    navbar.classList.toggle('active');
    if (userBox) userBox.classList.remove('active');
  };

  // Toggle the user info dropdown.
  const toggleUserBox = () => {
    if (!userBox) return;
    userBox.classList.toggle('active');
    if (navbar) navbar.classList.remove('active');
  };

  // Bootstraps page interactions after the DOM is ready.
  const init = () => {
    menuBtn?.addEventListener('click', toggleMenu);
    userBtn?.addEventListener('click', toggleUserBox);
    window.addEventListener('scroll', () => {
      stickyHeaderOnScroll();
      closeOnScroll();
    });
    stickyHeaderOnScroll();
    autoDismissMessages();
  };

  document.addEventListener('DOMContentLoaded', init);
})();
