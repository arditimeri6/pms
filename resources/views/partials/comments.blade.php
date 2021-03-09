<div class="row col-md-9 col-lg-9 col-sm-9 pull-left" style="background: white; border:solid 1px #e3e3e3; border-radius: 10px; ">
  
  <h2><i class="fas fa-comment-alt"></i> Comments</h2>      
  <div class="row">
    <div class="panel-body">
      <ul class="media-list">

        @foreach($comments as $comment)
          <li class="media">
            <div class="media-left">
                <img src="http://placehold.it/60x60" class="img-circle">
            </div>
              
            <div class="media-body">
                <h3 class="media-heading"><a href="users/{{ $comment->user->id }}"> {{ $comment->user->name }} </a>
                  <small>( {{ $comment->created_at }} )</small>
                </h3>
                <h4 class="text-danger">{{ $comment->url }}</h4>
                <p>{{ $comment->body }}</p>
            </div>
          </li>
        @endforeach

      </ul>
    </div> 
  </div>
</div>