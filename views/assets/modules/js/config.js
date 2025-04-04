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
//  code link list product //
// function confirmDelete(id) {
//     if (confirm('Are you sure you want to delete this product?')) {
//         let form = document.getElementById(`delete-form-${id}`);
//         if (form) {
//             form.submit();
//         } else {
//             console.warn(`Form with ID delete-form-${id} not found.`);
//         }
//     }
// }




            function searchProduct() {
                let input = document.getElementById("productSearch").value.toLowerCase();
                let rows = document.querySelectorAll("tbody tr");

                rows.forEach(row => {
                    let productName = row.querySelector("td:nth-child(2) span").textContent.toLowerCase();
                    if (productName.includes(input)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            }
            document.getElementById('exportPDF').addEventListener('click', exportPDF);
            document.getElementById('exportExcel').addEventListener('click', exportExcel);
            document.getElementById('exportCSV').addEventListener('click', exportCSV);

            // Export PDF using jsPDF
            function exportPDF() {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                doc.text("Hello, this is your exported PDF!", 10, 10);
                doc.save('document.pdf');
            }

            // Export Excel using SheetJS (xlsx library)
            function exportExcel() {
                const data = [
                    ["Header 1", "Header 2", "Header 3"],
                    ["Row 1, Col 1", "Row 1, Col 2", "Row 1, Col 3"],
                    ["Row 2, Col 1", "Row 2, Col 2", "Row 2, Col 3"]
                ];

                const ws = XLSX.utils.aoa_to_sheet(data);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

                // Generate the Excel file
                XLSX.writeFile(wb, 'document.xlsx');
            }

            // Export CSV
            function exportCSV() {
                const data = [
                    ["Header 1", "Header 2", "Header 3"],
                    ["Row 1, Col 1", "Row 1, Col 2", "Row 1, Col 3"],
                    ["Row 2, Col 1", "Row 2, Col 2", "Row 2, Col 3"]
                ];

                let csvContent = data.map(row => row.join(",")).join("\n");
                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                saveAs(blob, 'document.csv');
            }



        // filter category stock  ///
        function filterStock(stockType) {
            const rows = document.querySelectorAll('#categoryTable tr');
            
            rows.forEach(row => {
                const rowStock = row.getAttribute('data-stock'); // Fetch stock type from data-stock attribute
                
                // Show or hide rows based on the selected stock type
                if (stockType === '' || rowStock === stockType) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        
            // Update selected filter text in the button
            document.getElementById('selectedStock').textContent = stockType || 'Stock';
        }
        
        