{{$group->group_name}} <br>

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
        </tr>
    @endforeach
    </tbody>
</table>

<form class="form-inline" action="#" id="costParams">
    show result of: &nbsp;
    <select class="form-control mr-1" name="time">
        <option> current month </option>
        <option> last mont </option>
        <option> this year </option>
        <option> all time </option>
    </select>

{{--    TODO multiple select for members (by select2 tool)--}}
    <input type="submit" value="get result" class="btn btn-primary">
</form>

<table class="table table-striped table-hover">

</table>

<script>
    $(document).ready(function () {
        $("#costParams").submit(function () {
            alert("submited");
        });
    });
</script>
{{--TODO add cost for user him self belongs here--}}