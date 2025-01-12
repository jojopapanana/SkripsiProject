<x-layout title="Pengingat">
    <h1 class="fw-bold text-center responsive-margin-end" style="font-size: 2.5rem">PENGINGAT</h1>
    <h1 style="calender-text-width-adjust"></h1>

    <div id="calendar" class="p-5 mb-5 responsive-margin-end"></div>

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
                        <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed footer-button" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary custom-btn mt-2 footer-button">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editReminderModal" tabindex="-1" aria-labelledby="editReminderModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered custom-modal-width-reminder" role="document">
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
                        <button type="button" data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn p-0 delete-button footer-button-reminder reminder-delete-btn">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                        <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed footer-button-reminder tutup-btn" data-bs-dismiss="modal">Tutup</button>
                        @method('PUT')
                        <button type="submit" class="btn btn-primary custom-btn mt-2 footer-button-reminder">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body ps-4 pe-4 pb-4">
                    <center>
                        <i class="bi bi-exclamation-triangle-fill" style="font-size: 5rem; color: red"></i>
                    </center>

                    <h4 class="fw-bold text-center">Apakah Anda yakin ingin menghapus pengingat ini?</h4>

                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <button class="btn fw-semibold cancel-btn" data-bs-dismiss="modal">Tidak</button>

                        <form id="deleteReminderForm" method="POST">
                            <input type="hidden" name="_method" value="DELETE">
                            <button class="btn fw-semibold confirm-btn">Ya</button>
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

            // handle for when error happens in the backend
            $('#alertModal').on('hidden.bs.modal', function() {
                @if (session('errorDataUpdate'))
                    const errorData = @json(session('errorDataUpdate'));
                    $('#editReminderModal').modal('show'); 
                    $('#editReminderForm').attr('action', `{{ url('reminder/update') }}/${errorData.id}`);
                    $('#reminderId').val(errorData.id);
                    $('#editReminderName').val(errorData.judul);
                    $('#editReminderDeadline').val(errorData.deadline);
                    $('#editReminderDescription').val(errorData.deskripsi);
                @elseif (session('errorDataInput'))
                    const errorData = @json(session('errorDataInput'));
                    $('#addReminderModal').modal('show'); 
                    $('#judul').val(errorData.judul);
                    $('#deadline').val(errorData.deadline);
                    $('#deskripsi').val(errorData.deskripsi);
                @endif
            });

            $(document).on('input', '#editReminderName', enforceInputDeskripsi);
            $(document).on('input', '#judul', enforceInputDeskripsi);
            $(document).on('input', '#editReminderDescription', enforceInputDeskripsi);
            $(document).on('input', '#deskripsi', enforceInputDeskripsi);

            function enforceInputDeskripsi(event) {
                var input = event.target;
                var value = input.value;

                if (value.length > 255) {
                    value = value.slice(0, 255);
                    alert('Jumlah input karakter maksimal adalah 255 huruf!');
                }

                input.value = value;
            }
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
                <div class="modal-body ps-4 pe-4 pb-4">
                    <center>
                        <i id="modalIcon" class="bi bi-check-circle-fill" style="font-size: 5rem; color: rgb(0, 205, 0)"></i>
                    </center>
                    <h4 class="fw-bold text-center" id="modalText">Default Text</h4>
                    <div class="d-flex justify-content-center gap-4 mt-4">
                        <button class="btn fw-semibold cancel-btn" data-dismiss="modal">Oke</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Function to change modal text, icon, and show the modal -->
    <script>
        var alertModal = new bootstrap.Modal(document.getElementById('alertModal'));

        function showAlert(text, iconClass, iconColor) {
            document.getElementById('modalText').innerText = text;
            const modalIcon = document.getElementById('modalIcon');
            modalIcon.className = iconClass;
            modalIcon.style.color = iconColor;
            alertModal.show();
        }
    </script>

    @if (session('success'))
        <script>
            showAlert(
                '{{ session('success') }}',
                'bi bi-check-circle-fill',
                'rgb(0, 205, 0)' // Green for success
            );
        </script>
    @endif

    @if (session('error'))
        <script>
            showAlert(
                '{{ session('error') }}',
                'bi bi-exclamation-triangle-fill',
                'red' // Red for error
            );
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