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

<button class="btn btn-success" data-toggle="modal" data-target="#addCostModal"> add new cost in this group </button>

<!-- Add Cost Modal -->
<section class="modal fade" id="addCostModal">
    <div class="modal-dialog">
        <article class="modal-content">

            <!-- Modal Header -->
            <header class="modal-header">
                <h5 class="modal-title">Enter cost details</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </header>

            <!-- Modal body -->
            <article class="modal-body">
                <form action="/ajax/addCost" method="post" id="addCostForm">
                    @csrf
                    <input type="hidden" name="groupId" value="{{$group->id}}">
                    Cost descryption: <input type="text" class="form-control" name="costDescription"> <br>
                    Cost amount: <input type="text" class="form-control" name="costAmount">
                </form>
            </article>

            <!-- Modal footer -->
            <footer class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button class="btn btn-success" id="addCostBtn"> Create </button>
            </footer>

        </article>
    </div>
</section>

<form class="form-inline mt-2" action="#" id="costParams">
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
        $("#addCostBtn").click(function (){
            $("#addCostForm").submit();
        });
    });
</script>
{{--TODO add cost for user him self belongs here--}}