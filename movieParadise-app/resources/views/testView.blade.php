<!DOCTYPE html>
<html>
<head>
    <title>Laravel Ajax Data Fetch Example - ItSolutionStuff.com</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
        
<div class="container">
    <h1>Laravel Ajax Data Fetch Example - ItSolutionStuff.com</h1>
      
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/1" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>1</td>
<td>Iron Man</td>
<td>2008-04-30</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/3" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>3</td>
<td>Iron Man 2</td>
<td>2010-04-28</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/4" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>4</td>
<td>Iron Man 3</td>
<td>2013-04-18</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/5" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>5</td>
<td>Avengers: Infinity War</td>
<td>2018-04-25</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/6" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>6</td>
<td>The Avengers</td>
<td>2012-04-25</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/7" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>7</td>
<td>Avengers: Endgame</td>
<td>2019-04-24</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/8" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>8</td>
<td>Avengers: Age of Ultron</td>
<td>2015-04-22</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/9" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>9</td>
<td>Captain America: The First Avenger</td>
<td>2011-07-22</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/10" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>10</td>
<td>Transformers: Age of Extinction</td>
<td>2014-06-25</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            <tr>
<td>
<ul class="action-list">
<a href="javascript:void(0)" id="edit-film" data-url="http://127.0.0.1:8000/edit/film/11" class="btn btn-primary"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a>
</ul>
</td>
<td>11</td>
<td>Transformers: The Last Knight</td>
<td>2017-06-16</td>
<td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i></a></td>
</tr>
            
</tbody>
    </table>
  
  
</div>
  
<!-- Modal -->
<div class="modal fade" id="userShowModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Show User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>ID:</strong> <span id="user-id"></span></p>
        <p><strong>Name:</strong> <span id="user-name"></span></p>
        <p><strong>Email:</strong> <span id="user-email"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
      
</body>
  
<script type="text/javascript">
      
    $(document).ready(function () {
       
       /* When click show user */
        $('body').on('click', '#edit-film', function () {
          var userURL = $(this).data('url');
          $.get(userURL, function (data) {
              $('#userShowModal').modal('show');
              $('#user-id').text(data.id);
              $('#user-name').text(data.titre);
              $('#user-email').text(data.resume);
          })
       });
       
    });
  
</script>
      
</html>