group name: {{$group->group_name}} <br> <br>

members: <br>
<table class="table table-striped table-hover col-4">
    <thead>
    <tr>
        <th> Member name </th>
    </tr>
    </thead>
    <tbody>
    @foreach($members as $member)
        <tr>
            <td> {{$member->name}} </td>
            <td> <button class="btn btn-danger" id="{{$member->id}}"> Remove </button> </td>
        </tr>
    @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $(".btn").click(function () {
            memberId = $(this).attr('id');
            $.post('http://localhost:8000/Groups/removeMember', {_token:"{{csrf_token()}}" ,memberId: memberId, groupId: {{$group->id}}},
                function (data) {
                    alert(data);
                    $.post('http://localhost:8000/ajax/manageSpecificGroup', {_token:"{{csrf_token()}}" ,groupId: {{$group->id}}},
                        function (data) {
                        $("#main").html(data);
                    });
            });
        });
    });
</script>
