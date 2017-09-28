<html>
<head>
<title>Example Study Selection</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
</head>
<body>
<form>
<table border="2">
	<col width="200">
	<col width="200">
<tr>
	<td>
	Study Name
	</td>
	<td>
	Experimenter Name
	</td>
</tr>
<tr>
	<td>
	Estimated Time
	</td>
	<td>
	Available Times
	</td>
</tr>
<tr>
	<td colspan="2">
	Study Description
	</td>
</tr>
<tr>
	<td>
	Points Available
	</td>
	<td>
	Eligible Classes
	</td>
</tr>
</table>
</form>

<div class="modal fade" id="myModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Update Name List</h4>
            </div>
            <div class="modal-body">

                <form id="my-form">
                    <div id="firstNameDiv" class="form-group has-feedback">
                        <label class="control-label" for="firstName">First Name:</label>
                        <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First name" aria-describedby="firstNameStatus"/>
                        <span id="firstNameGlyph" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="firstNameStatus" class="sr-only"></span> <!-- Text goes in firstNameStatus for screen readers that can't see our icons. -->

                       <!-- <label for="firstName">First Name:</label>
                        <input type="hidden" id="id" name="id" class="form-control" /><br />
                        <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First name"/><br />
                        <label for="lastName">Last Name:</label>
                        <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last name"/><br />
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email address"/><br />
                        -->
                    </div>

                    <div id="lastNameDiv" class="form-group has-feedback">
                        <label class="control-label" for="lastName">Last Name:</label>
                        <input type="text" id="lastName" name="lastName" class="form-control" placeholder="Last name" aria-describedby="lastNameStatus"/>
                        <span id="lastNameGlyph" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="lastNameStatus" class="sr-only"></span>
                    </div>

                    <div id="emailDiv" class="form-group has-feedback">
                        <label class="control-label" for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email address" aria-describedby="emailStatus"/>
                        <span id="emailGlyph" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="emailStatus" class="sr-only"></span>
                    </div>

                    <div id="phoneDiv" class="form-group has-feedback">
                        <label class="control-label" for="phone">Phone:</label>
                        <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone number" aria-describedby="phoneStatus"/>
                        <span id="phoneGlyph" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="phoneStatus" class="sr-only"></span>
                    </div>

                    <div id="birthdayDiv" class="form-group has-feedback">
                        <label class="control-label" for="birthday">Birthday:</label>
                        <input type="date" id="birthday" name="birthday" class="form-control" placeholder="Birthday" aria-describedby="birthdayStatus"/>
                        <span id="birthdayGlyph" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="birthdayStatus" class="sr-only"></span>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="saveChanges" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>
</html>