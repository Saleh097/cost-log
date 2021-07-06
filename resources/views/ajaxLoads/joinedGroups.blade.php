Joined Groups <br>
<table class="table table-dark table-striped table-hover text-center col-4">
    <thead>
    <tr>
        <th> group name </th>
        <th> group admin </th>
    </tr>
    </thead>
    <tbody>
    @foreach($groups as $group)
        <tr class="groupRow" id="{{$group->id}}">
            <td> {{$group->group_name}} </td>
            <td> {{$group->admin_name}} </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function () {
       $(".groupRow").click(function () {
           let groupId = $(this).attr("id");
           $.post('http://localhost:8000/ajax/groupDetails', {_token:"{{csrf_token()}}" ,groupId: groupId}, function (data) {
               $("#main").html(data);
           });
       }); 
    });
</script>