
$(function () {
  "use strict"
  $(document).on('click', '#print_barcode_wrap', function (e) { 
    let printContents = document.getElementById('barcode_wrap').innerHTML;
    let originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  });
  // $(document).on('click', '#label_print_wrap', function (e) { 
  //   let printContents = document.getElementById('label_barcode_wrap').innerHTML;
  //   let originalContents = document.body.innerHTML;
  //   document.body.innerHTML = printContents;
  //   window.print();
  //   document.body.innerHTML = originalContents;
  // });


  $(document).on('click', '#label_print_wrap', function (e) {
    e.preventDefault();
    let printContents = document.getElementById('label_barcode_wrap').innerHTML;
    let printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write(`
      <html>
        <head>
          <title>Print Labels</title>
          <style>
            /* Add any CSS styles here for the printed content */
            body { font-family: Arial, sans-serif; margin: 20px; }
          </style>
        </head>
        <body>
          ${printContents}
        </body>
      </html>
    `);
    printWindow.document.close();
    printWindow.print();
    printWindow.close();
});


});