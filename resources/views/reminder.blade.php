<x-layout title="Pengingat">
    <div class="d-flex justify-content-center" style="width: 70vw">
        <h1 class="fw-bold">PENGINGAT</h1>
    </div>

    <div id="calendar" class="p-5 mt-3 mb-3" style="color: black"></div>

    <div class="modal fade" id="addReminderModal" tabindex="-1" aria-labelledby="addReminderModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content pl-3 pr-3">
                <div class="modal-header justify-content-center">
                    <p class="modal-title" id="exampleModalLabel">Tambah Pengingat</p>
                </div>
                <form action="{{ route('reminder.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group position-relative mb-2">
                            <label for="judul" class="col-form-label" id="inputModalLabel">Judul</label>
                            <input type="text" class="form-control border-style" id="judul" name="judul" placeholder="Masukkan judul pengingat" required>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="deadline" class="col-form-label" id="inputModalLabel">Tanggal</label>
                            <input type="date" class="form-control border-style" id="deadline" name="deadline" required>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="deskripsi" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                            <textarea class="form-control border-style" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan detail deskripsi pengingat" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer mb-2">
                        <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary custom-btn mt-2">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editReminderModal" tabindex="-1" aria-labelledby="editReminderModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content pl-3 pr-3">
                <div class="modal-header justify-content-center">
                    <p class="modal-title" id="exampleModalLabel">Detail Pengingat</p>
                </div>
                <form id="editReminderForm" method="POST">
                    @csrf
                    @method('UPDATE')
                    <div class="modal-body">
                        <input type="hidden" id="reminderId" name="reminderId">
                        <div class="form-group position-relative mb-2">
                            <label for="judul" class="col-form-label" id="inputModalLabel">Judul</label>
                            <input type="text" class="form-control border-style" id="editReminderName" name="judul" required>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="deadline" class="col-form-label" id="inputModalLabel">Tanggal</label>
                            <input type="date" class="form-control border-style" id="editReminderDeadline" name="deadline" required>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="deskripsi" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                            <textarea class="form-control border-style" id="editReminderDescription" name="deskripsi" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer mb-2">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn p-0 me-5 delete-button" style="border: none; font-size: 1.2rem">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                        <button type="button" class="btn btn-primary custom-btn ms-3 mt-2 btn-closed" data-bs-dismiss="modal">Tutup</button>
                        @method('PUT')
                        <button type="submit" class="btn btn-primary custom-btn mt-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <center>
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
                    </center>

                    <h4 class="fw-bold text-center">Apakah Anda yakin ingin menghapus pengingat ini?</h4>

                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <button class="btn fw-semibold" style="border: 2px solid black; width: 5vw" data-bs-dismiss="modal">Tidak</button>

                        <form id="deleteReminderForm" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn fw-semibold" style="background-color: rgba(210, 0, 0, 1); width: 5vw; color: white">Ya</button>
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/locales-all.min.js"></script>

    <script>
        $(document).ready(function() {
            // When the "Tidak" button is clicked and the delete modal is closed, show the edit modal again
            $('#deleteModal').on('hidden.bs.modal', function() {
                // Reopen the edit reminder modal
                $('#editReminderModal').modal('show');
            });

            // If the delete button in the delete modal is clicked, ensure the modal doesn't reopen
            $('#deleteReminderForm').on('submit', function() {
                $('#deleteModal').off('hidden.bs.modal'); // Remove the reopen behavior
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Clear the values of 'judul' and 'deskripsi' every time the modal is shown
            $('#addReminderModal').on('show.bs.modal', function() {
                $('#judul').val('');
                $('#deskripsi').val('');
            });
        });
    </script>

    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Alert Modal Component -->
    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="okModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <center>
                        <i class="bi bi-check-circle-fill" style="font-size: 5rem; color: rgb(0, 205, 0)"></i>
                    </center>
                    <h4 class="fw-bold text-center" id="modalText">Default Text</h4>
                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <button class="btn fw-semibold" style="border: 2px solid black; width: 5vw" data-dismiss="modal">Oke</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Function to change modal text and show the modal -->
    <script>
        var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));

        function showAlert(text) {
            document.getElementById('modalText').innerText = text;
            alertModal.show();
        }
    </script>

    @if (session('success'))
        <script>
            showAlert('{{ session('success') }}');
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'id',
                locales: [{
                    code: 'id',
                    buttonText: {
                        today: 'Hari Ini',
                        month: 'Bulan',
                        week: 'Minggu',
                        day: 'Hari',
                    }
                }],
                initialView: 'dayGridMonth',
                dayMaxEvents: true,
                textColor: 'black',
                dateClick: function(info) {
                    $('#deadline').val(info.dateStr);
                    $('#addReminderModal').modal('show');
                },
                eventClick: function(info){
                    const event = info.event;
                    const reminderId = event.id;
                    const title = event.title;
                    const originalDate = new Date(event.start);
                    originalDate.setDate(originalDate.getDate() + 1);
                    const date = originalDate.toISOString().split('T')[0];
                    const description = event.extendedProps.description;

                    document.getElementById('editReminderForm').action = `{{ url('/reminder/update') }}/${reminderId}`;
                    document.getElementById('editReminderName').value = title;
                    document.getElementById('editReminderDeadline').value = date;
                    document.getElementById('editReminderDescription').value = description;

                    const deleteForm = document.getElementById('deleteReminderForm');
                    deleteForm.action = `{{ url('/reminder/delete') }}/${reminderId}`;

                    $('#editReminderModal').modal('show');
                },
                events: [
                    @foreach($reminders as $reminder)
                    {
                        id: '{{ $reminder->id }}',
                        title: '{{ $reminder->reminderName }}',
                        start: '{{ $reminder->reminderDeadline }}',
                        description: '{{ $reminder->reminderDescription }}',
                        display: 'block',
                        textColor: 'white'
                    },
                    @endforeach
                ]
            });
    
            calendar.render();
        });
    </script>
</x-layout>