<div class="row">
    @for ($i = 0; $i < ($count ?? 6); $i++)
        <div class="col-md-4 mb-4">
            <div class="bug-card">
                <div class="d-flex justify-content-between mb-2">
                    <div class="skeleton-loader badge"></div>
                    <div class="skeleton-loader badge"></div>
                </div>
                
                <div class="skeleton-loader title"></div>
                
                <div class="skeleton-loader text"></div>
                <div class="skeleton-loader text"></div>
                
                <div class="bug-card__meta">
                    <div class="skeleton-loader text" style="width: 40%;"></div>
                    <div class="skeleton-loader text" style="width: 40%;"></div>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <div class="skeleton-loader button me-2" style="width: 60px;"></div>
                    <div class="skeleton-loader button" style="width: 60px;"></div>
                </div>
            </div>
        </div>
    @endfor
</div>