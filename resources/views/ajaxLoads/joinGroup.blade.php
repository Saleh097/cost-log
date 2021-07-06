<span class="form-inline mb-2"> Enter Group name: <input type="text" name="groupName" id="gpName" class="form-control col-4 mx-1">
<button id="searchTrigger" type="button" class="btn btn-primary"> search </button> </span>

@if(isset($groups) && $groups===0)
    <script>
        alert("no groups with this name found");
    </script>
@elseif(isset($groups))
    <section class="card-columns">
    @foreach($groups as $group)
        <div class="card bg-primary group_card" id="{{$group["id"]}}">
            <span class="card-body text-center">
                <p class="card-text"> {{$group["group_name"]}} created by {{$group["admin_name"]}} </p>
            </span>
        </div>
    @endforeach
    </section>
@endif



<script>

    $(document).ready(function () {
        $("#searchTrigger").click(function () {
            let gpName = $("#gpName").val(); //because next line deletes it
            $("#main").text("... please wait ...");
            $("#main").load("http://localhost:8000/ajax/joinToGroup/" + gpName);
        });

        $(".group_card").click(function (){ //$(this).attr("id")
            let groupId = $(this).attr("id");
            $.post('http://localhost:8000/Groups/JoinRequest', {_token:"{{csrf_token()}}" ,groupId: groupId}, function (data) {
                alert(data);
            });
        });
    });
</script>

