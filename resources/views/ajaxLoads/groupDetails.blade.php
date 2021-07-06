{{$group->group_name}} <br>

members: <br>
<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th> Member name </th>
    </tr>
    </thead>
    <tbody>
    @foreach($members as $member)
        <tr>
            <td> {{$member->name}} </td>
        </tr>
    @endforeach
    </tbody>
</table>

<form


{{--TODO add cost for user him self belongs here--}}