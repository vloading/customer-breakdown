$(document).ready(function() {
    $('#week-report').DataTable({
        "lengthMenu": [20, 40, 60, 80, 100],
        "pageLength": 20,
        stateSave: true,

        // columnDefs: [
        //     {
        //         targets: [4], // Replace columnIndex with the index of the date and time column (0-based index)
        //         type: 'date', // Specify the column type as 'date'
        //         render: function(data, type, row) {
        //             if (type === 'sort') {
        //                 // Convert the date and time format to a sortable format
        //                 return moment(data, 'MMM-DD-YYYY HH:mm:ss').format('YYYY-MM-DD HH:mm:ss');
        //             }
        //             return data;
        //         }
        //     }
        // ]
        
        //dom: '<"top"i>rt<"bottom"flp><"clear">'

        // dom: 'Bfrtip',
        // pageLength: 20 ,
        // buttons: [
        //     'copy', 'csv', 'excel', 'pdf', 'print'
        // ]
    } );
} );