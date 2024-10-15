@if($condition != 'today')
    <div class="row">
        <div class="accordion mb-4" id="accordionExample">
            <div class="accordion-item" >
                <h2 class="accordion-header" id="headingTwo">
                    <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo"
                            aria-expanded="false"
                            aria-controls="collapseTwo"
                    >
                        Search Filter
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body h-auto">
                        <form action="" method="get" >
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="row" style="align-items: center;">
                                        <div class="col-md-4">
                                            <label for="inputFromDate" >Trial class date</label>
                                        </div>
                                        <div class="col-md-8 p-0">
                                            <input type="date" name="date" id="date" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card ">
            <div class="card-body table-responsive overflow-auto" id="trial-class-data">
                @include('teacher.trial-class.tabs.includes._trial_class_data')
            </div>
        </div>
    </div>
</div>

<script >
    $(document).ready(function() {
        $('#date').change(function() {
            $(".loader-populate").html("<div id='loader-main'><div id='loader2'></div></div>");
            let date = $('#date').val();
            let condition = "{{ $condition }}";
            $.ajax({
                url: "{{ route('teacher.trial.class.data') }}",
                type: 'GET',
                data: {
                    date: date,
                    condition: condition
                },
                success: function(response) {
                    $('#trial-class-data').html(response);
                    $(".loader-populate").html("");
                }
            });
        });
    });


</script>