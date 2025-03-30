<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th width="20%">Title</th>
                <th width="25%">Description</th>
                <th width="10%">Priority</th>
                <th width="10%">Status</th>
                <th width="15%">Reported By</th>
                <th width="20%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < ($rows ?? 5); $i++)
                <tr>
                    <td><div class="skeleton-loader text"></div></td>
                    <td><div class="skeleton-loader text"></div></td>
                    <td><div class="skeleton-loader badge"></div></td>
                    <td><div class="skeleton-loader badge"></div></td>
                    <td><div class="skeleton-loader text"></div></td>
                    <td>
                        <div class="d-flex">
                            <div class="skeleton-loader button me-2" style="width: 60px;"></div>
                            <div class="skeleton-loader button" style="width: 60px;"></div>
                        </div>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>