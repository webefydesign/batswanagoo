    <section class="contact_sec">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="sforms ml-0">
                        <form action="{{ url('careers') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>{!! ($meta['heading'])??'' !!}</h3>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="col-sm-6 mt-3">
                                    <div>
                                        <label for="name">Name</label>
                                        <input type="text" name="name" placeholder="Enter Name" id="name" class="form-control" required parsley-type="name">
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div>
                                        <label for="number">Phone number</label>
                                        <input type="number" name="number" placeholder="Enter Phone number" id="number" class="form-control" required parsley-type="number">
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div>
                                        <label for="email">Email address</label>
                                        <input type="email" name="email" placeholder="Enter Email Address" id="email" class="form-control" required parsley-type="email">
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div>
                                        <label for="address">Address</label>
                                        <input type="text" name="address" placeholder="Enter Address" id="address" class="form-control" required parsley-type="address">
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-3">
                                    <div>
                                        <label for="file">Attachment CV</label>
                                        <input type="file" name="file" id="file" class="form-control" accept=".doc,.docx,.pdf" required parsley-type="file">
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-3">
                                    <div>
                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- sm6 -->
            </div>
        </div>
    </section>
