<section class="section">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <img class="img-fluid" src="{{ (!empty($getAttachmentInfo->attachment) ? url($getAttachmentInfo->attachment) : '') }}" alt="{{ $getAttachmentInfo->notes }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>