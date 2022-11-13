<!doctype html>
  
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <title>Pdf content</title>
</head>
<body>
    <iframe height="400" width="400" src="/storage/uploads/{{ $filename }}"></iframe>
    <div id="my_pdf_viewer">
        <div id="canvas_container">
            <canvas id="pdf_renderer"></canvas>
        </div>
        <div id="navigation_controls">
            <button id="go_previous">Previous</button>
            <input id="current_page" value="1" type="number"/>
            <button id="go_next">Next</button>
        </div>
        <div id="zoom_controls">  
            <button id="zoom_in">+</button>
            <button id="zoom_out">-</button>
        </div>
    </div>
    <!-- <script
        src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js">
    </script> -->
    <!-- <script src="{{ asset('assets/js/pdf.js') }}"></script>
    <script src="{{ asset('assets/js/pdf.worker.js') }}"></script> -->
    <script>
        //var file = "{{ asset('storage/uploads/'.$filename) }}";
        // var myState = {
        //     pdf: null,
        //     currentPage: 1,
        //     zoom: 1
        // }
  
        // pdfjsLib.getDocument(file).then((pdf) => {
        //     myState.pdf = pdf;
        //     render();
        // });

        // function render() {
        //     myState.pdf.getPage(myState.currentPage).then((page) => {
        //         var canvas = document.getElementById("pdf_renderer");
        //         var ctx = canvas.getContext('2d');
  
        //         var viewport = page.getViewport(myState.zoom);
        //         canvas.width = viewport.width;
        //         canvas.height = viewport.height;

        //         page.render({
        //             canvasContext: ctx,
        //             viewport: viewport
        //         });
        //     });
        // }
    </script>
</body>
</html>