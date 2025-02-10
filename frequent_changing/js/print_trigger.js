$(function () {
  "use strict"
  $(document).on('click', '#print_trigger', function (e) { 
    let printContents = document.getElementById('printableArea').innerHTML;
    let originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
  });
});
