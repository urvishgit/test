<div class="col-12 col-md-8 m-auto text-center">
	<form method="post" action="/wallet/DeleteWallet" class=" my-5">
	  <div class="form-group text-left">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Enter your name">
		<small id="nameHelp" class="form-text text-muted">We'll never share your any detail with anyone else.</small>
	  </div>
	  <div class="form-group text-left">
		<label for="hashkey">Hashkey</label>
		<input type="password" class="form-control" name="hashkey" id="hashkey" placeholder="Enter your hashkey">
	  </div>
	  
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>