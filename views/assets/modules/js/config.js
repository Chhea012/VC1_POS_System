/**
 * Config
 * -------------------------------------------------------------------------------------
 * ! IMPORTANT: Make sure you clear the browser local storage In order to see the config changes in the template.
 * ! To clear local storage: (https://www.leadshook.com/help/how-to-clear-local-storage-in-google-chrome-browser/).
 */

'use strict';

// JS global variables
let config = {
  colors: {
    primary: '#696cff',
    secondary: '#8592a3',
    success: '#71dd37',
    info: '#03c3ec',
    warning: '#ffab00',
    danger: '#ff3e1d',
    dark: '#233446',
    black: '#000',
    white: '#fff',
    body: '#f4f5fb',
    headingColor: '#566a7f',
    axisColor: '#a1acb8',
    borderColor: '#eceef1'
  }
};





document.addEventListener('DOMContentLoaded', function() {
  // Get all menu items
  const menuItems = document.querySelectorAll('.menu-item');
  const currentPath = window.location.pathname;

  // Set initial active state based on current URL
  menuItems.forEach(item => {
      const link = item.querySelector('a:not(.menu-toggle)');
      if (link && link.getAttribute('href') === currentPath) {
          item.classList.add('active');
          // Activate parent menu items
          let parent = item.closest('.menu-item');
          while (parent) {
              parent.classList.add('active');
              parent = parent.parentElement.closest('.menu-item');
          }
      }
  });

  // Handle menu item clicks
  menuItems.forEach(item => {
      const link = item.querySelector('.menu-link');
      if (link) {
          link.addEventListener('click', function(e) {
              // Check if it's a toggle link
              if (this.classList.contains('menu-toggle')) {
                  e.preventDefault();
                  const submenu = this.nextElementSibling;
                  if (submenu && submenu.classList.contains('menu-sub')) {
                      $(submenu).slideToggle(200);
                      this.parentElement.classList.toggle('open');
                  }
                  return;
              }

              // Remove active from all items
              menuItems.forEach(menu => menu.classList.remove('active'));
              
              // Add active to clicked item and its parents
              let currentItem = this.parentElement;
              currentItem.classList.add('active');
              
              while (currentItem) {
                  const parent = currentItem.parentElement.closest('.menu-item');
                  if (parent) parent.classList.add('active');
                  currentItem = parent;
              }
          });
      }
  });
});



