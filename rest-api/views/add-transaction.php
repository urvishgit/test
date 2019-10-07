<div class="col-12 col-md-8 m-auto text-center">
	<form method="post" action="/wallet/AddTransaction" class=" my-5">
	  <div class="form-group text-left">
		<label for="name">Name</label>
		<input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Enter your name">
		<small id="nameHelp" class="form-text text-muted">We'll never share your any detail with anyone else.</small>
	  </div>
	  
	  <div class="form-group text-left">
		<label for="type">Type</label>
		<select class="form-control" name="type" id="type">
		  <option value="bet">BET</option>
		  <option value="win">WIN</option>
		</select>
	  </div>
	  
	  <div class="form-group text-left">
		<label for="amount">Amount</label>
		<input type="text" class="form-control" id="amount" name="amount" aria-describedby="amountHelp" placeholder="Enter your amount">
		<small id="amountHelp" class="form-text text-muted">If BET then amount need to be <= 0, if Win amount need to be >= 0.</small>
	  </div>
	  
	  <div class="form-group text-left">
		<label for="reference">Reference</label>
		<input type="text" class="form-control" id="reference" name="reference" aria-describedby="referenceHelp" placeholder="Enter your reference">
		<small id="referenceHelp" class="form-text text-muted">Reference must start with TR-</small>
	  </div>
	  
	  <button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>