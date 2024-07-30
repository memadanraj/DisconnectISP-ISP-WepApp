// Initiate datatables in roles, tables, users page
(function() {
    'use strict';
    
    $('#dataTables-example').DataTable({
        responsive: true,
        pageLength: 5,
        lengthChange: false,
        searching: true,
        ordering: true
    });
})();