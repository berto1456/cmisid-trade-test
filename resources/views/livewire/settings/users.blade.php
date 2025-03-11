<div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Users</h5>
        <div class="col-4 text-start">
          <input type="text" class="form-control" placeholder="search" wire:model.live="search">
        </div>
        <div class="text-end">
          <button type="button" class="btn {{ $archive ? 'btn-success' : 'btn-warning' }}" wire:click="toggleArchive">
            {{ $archive ? 'General' : 'Archive' }}
          </button>
          <button type="button" class="btn btn-primary" wire:click='clear' data-bs-toggle="modal" data-bs-target="#userModal">
            Add
          </button>

        </div>


        <!-- Table with stripped rows -->
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Status</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $item)
            <tr>
              <td scope="row">{{$item->id}}</td>
              <td>{{$item->name}}</td>
              <td>{{$item->email}}</td>
              <td>
                <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                  {{$item->deleted_at == Null ? 'active': 'inactive'}}
                </span>

              </td>
              <td>
                <button class="btn btn-secondary" wire:click='readUser({{$item->id}})'>
                  Edit
                </button>

                <button class="{{$item->deleted_at == Null ? 'btn btn-danger': 'btn btn-success'}}" wire:click='{{$item->deleted_at == Null ? 'deleteUser('.$item->id.')': 'restoreUser('.$item->id.')'}}'>
                  {{$item->deleted_at == Null ? 'Delete': 'Restore'}}
                </button>
              </td>
            </tr>
            @empty
            <tr>
              <th colspan="5">No Record</th>
            </tr>

            @endforelse
          </tbody>
        </table>
        <!-- End Table with stripped rows -->
        <div>
          {{$users->links()}}
        </div>
      </div>
    </div>


    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-lg" style="width: 100%; height: 90%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="userModalLabel">{{$editMode ? 'Update' : 'Add'}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
          </div>
          <div class="modal-body">
            <form class="row g-3" wire:submit="{{$editMode ? 'updateUser' : 'createUser'}}">
              <div class="container">
                <div class="row">
                  <!-- Left Column -->
                  <div class="col-md-6">
                    <div class="col-12">
                      <label for="inputNanme4" class="form-label">Your Name</label>
                      <input type="text" class="form-control" wire:model="name">
                      @error('name')
                      <div class="custom-invalid-feedback">
                        {{$message}}
                      </div>
                      @enderror
                    </div>
                    <div class="col-12">
                      <label for="inputEmail4" class="form-label">Email</label>
                      <input type="email" class="form-control" wire:model="email">
                      @error('email')
                      <div class="custom-invalid-feedback">
                        {{$message}}
                      </div>
                      @enderror
                    </div>
                    <div class="col-12">
                      <label for="office" class="form-label">Office</label>
                      <select class="form-select">
                        <option value="option1">1</option>
                        <option value="option2">2</option>
                        <option value="option3">3</option>
                        <option value="option4">4</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label for="inputemployeeid" class="form-label">Employee ID</label>
                      <input type="text" class="form-control" wire:model="employeeid" id="inputemployeeid" placeholder="#">
                      @error('employeeid')
                      <div class="custom-invalid-employeeid">
                        {{$message}}
                      </div>
                      @enderror
                    </div>
                  </div>

                  <!-- Right Column -->
                  <div class="col-md-6">
                    <div class="col-12">
                      <label for="type" class="form-label">Type</label>
                      <select id="type" class="form-select">
                        <option value="option1">1</option>
                        <option value="option2">2</option>
                        <option value="option3">3</option>
                        <option value="option4">4</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Permission</label>
                      <div class="form-check">
                        <input type="radio" class="form-check-input" id="assessor" name="optradio" value="Assessor" checked>
                        <label class="form-check-label" for="assessor">Assessor</label>
                      </div>
                      <div class="form-check">
                        <input type="radio" class="form-check-input" id="secretariat" name="optradio" value="Secretariat">
                        <label class="form-check-label" for="secretariat">Secretariat</label>
                      </div>
                    </div>

                    <div class="col-12">
                      <label class="form-label">Accounts</label>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="add-accounts" name="accounts[]" value="add">
                            <label class="form-check-label" for="add-accounts">Add</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="update-accounts" name="accounts[]" value="update">
                            <label class="form-check-label" for="update-accounts">Update</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="view-accounts" name="accounts[]" value="view">
                            <label class="form-check-label" for="view-accounts">View</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="delete-accounts" name="accounts[]" value="delete">
                            <label class="form-check-label" for="delete-accounts">Delete</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label class="form-label">Candidates</label>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="add-candidates" name="candidates[]" value="add">
                            <label class="form-check-label" for="add-candidates">Add</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="update-candidates" name="candidates[]" value="update">
                            <label class="form-check-label" for="update-candidates">Update</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="view-candidates" name="candidates[]" value="view">
                            <label class="form-check-label" for="view-candidates">View</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="delete-candidates" name="candidates[]" value="delete">
                            <label class="form-check-label" for="delete-candidates">Delete</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label class="form-label">Reference</label>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="add-reference" name="reference[]" value="add">
                            <label class="form-check-label" for="add-reference">Add</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="update-reference" name="reference[]" value="update">
                            <label class="form-check-label" for="update-reference">Update</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="view-reference" name="reference[]" value="view">
                            <label class="form-check-label" for="view-reference">View</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="delete-reference" name="reference[]" value="delete">
                            <label class="form-check-label" for="delete-reference">Delete</label>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label class="form-label">Exam</label>
                      <div class="row">
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="add-exam" name="exam[]" value="add">
                            <label class="form-check-label" for="add-exam">Add</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="update-exam" name="exam[]" value="update">
                            <label class="form-check-label" for="update-exam">Update</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="view-exam" name="exam[]" value="view">
                            <label class="form-check-label" for="view-exam">View</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="delete-exam" name="exam[]" value="delete">
                            <label class="form-check-label" for="delete-exam">Delete</label>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
          </div>



          {{-- <div class="col-12">
                      <label for="inputPassword4" class="form-label">Password</label>
                      <input type="password" class="form-control" id="inputPassword4">
                    </div> --}}
          <div class="text-center p-3">
            <button type="submit" class="btn btn-primary">Submit</button>
            {{-- <button type="reset" class="btn btn-secondary" wire:click='clear'>Reset</button> --}}
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='clear'>Close</button>
          </div>

          </form>
        </div>
        {{-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" wire:click='clear'>Save changes</button>
                </div> --}}
      </div>
    </div>
</div>
</section>
</div>

@script
<script>
  $wire.on('hide-userModal', () => {
    console.log('Hiding user modal');
    $('#userModal').modal('hide');
  });

  $wire.on('show-userModal', () => {
    console.log('Showing user modal');
    $('#userModal').modal('show');
  });
</script>
@endscript