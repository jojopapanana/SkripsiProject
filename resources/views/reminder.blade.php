<x-layout title="Pengingat">
    <div id="calendar" class="p-5" style="color: black"></div>

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
                            <label for="judul" class="col-form-label" id="inputModalLabel">Judul Pengingat</label>
                            <input type="text" class="form-control border-style" id="judul" name="judul" placeholder="Menerima barang, Membayar sewa, ..." required>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="deadline" class="col-form-label" id="inputModalLabel">Tanggal Pengingat</label>
                            <input type="date" class="form-control border-style" id="deadline" name="deadline" required>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="deskripsi" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                            <input type="text" class="form-control border-style" id="deskripsi" name="deskripsi" placeholder="Barang masuk 30 buah, ..." required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary custom-btn mt-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editReminderModal" tabindex="-1" aria-labelledby="editReminderModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content pl-3 pr-3">
                <div class="modal-header justify-content-center">
                    <p class="modal-title" id="exampleModalLabel">Ubah Pengingat</p>
                </div>
                <form id="editReminderForm" method="POST">
                    @csrf
                    @method('UPDATE')
                    <div class="modal-body">
                        <input type="hidden" id="reminderId" name="reminderId">
                        <div class="form-group position-relative mb-2">
                            <label for="judul" class="col-form-label" id="inputModalLabel">Judul Pengingat</label>
                            <input type="text" class="form-control border-style" id="editReminderName" name="judul" required>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="deadline" class="col-form-label" id="inputModalLabel">Tanggal Pengingat</label>
                            <input type="date" class="form-control border-style" id="editReminderDeadline" name="deadline" required>
                        </div>
                        <div class="form-group position-relative mb-2">
                            <label for="deskripsi" class="col-form-label" id="inputModalLabel">Deskripsi</label>
                            <input type="text" class="form-control border-style" id="editReminderDescription" name="deskripsi" required>
                        </div>
                        <div class="modal-footer p-0">
                            <form id="deleteReminderForm" method="POST" action="{{ route('reminder.delete', $reminder->id) }}">>
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="reminder_id" id="deleteReminderId">
                                <button class="btn fw-semibold" style="background-color: rgba(210, 0, 0, 1); width: 5vw; color: white">Hapus</button>
                            </form>
                            <button type="button" class="btn btn-primary custom-btn mt-2 btn-closed" data-bs-dismiss="modal">Tutup</button>
                            @method('PUT')
                            <button type="submit" class="btn btn-primary custom-btn mt-2">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
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

            // document.querySelector('#deleteReminderForm button').addEventListener('click', function(e) {
            //     e.preventDefault();
            //     if (confirm('Are you sure you want to delete this reminder?')) {
            //         document.getElementById('deleteReminderForm').action = `{{ url('/reminder/delete') }}/${reminderId}`;
            //         document.getElementById('deleteReminderForm').submit();
            //     }
            // });
        });
    </script>
</x-layout>