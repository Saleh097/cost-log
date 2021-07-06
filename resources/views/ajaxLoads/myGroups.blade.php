Groups created by you <br>
<table class="table table-dark table-striped table-hover text-center col-4">
    <thead>
    <tr>
        <th> group name </th>
    </tr>
    </thead>
    <tbody>
    @foreach($groups as $group)
        <tr id="{{$group->id}}">
            <td> {{$group->group_name}} </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{--//TODO add waiting to join groups--}}