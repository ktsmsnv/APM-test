
<div class="notes">
    <h2>Дневник проекта</h2>
    <ul>
        @forelse ($notes as $note)
            <li>
                <div class="date-comment">
                    <span>{{ $note->date }}</span>
                    <p>{{ $note->comment }}</p>
                </div>
                <div class="d-flex gap-2">
                    <a class="btn btn-light" href="#" data-bs-toggle="modal" data-bs-target="#editNotes{{ $note->id }}">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <form action="{{ route('tables.notes-delete', ['project' => $project->id, 'note' => $note->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit"><i class="fa-solid fa-trash-can"></i></button>
                    </form>
                </div>
            </li>

            {{-- Модальное окно редактирования записи --}}
            <div class="modal fade" id="editNotes{{ $note->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editNotesLabel{{ $note->id }}" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <form action="{{ route('tables.notes-update', ['project' => $project->id, 'note' => $note->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editNotesLabel{{ $note->id }}">Редактировать запись</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <textarea name="comment" placeholder="Введите текст заметки" required>{{ $note->comment }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit">Сохранить изменения</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        @empty
            <li>Нет записей.</li>
        @endforelse
    </ul>

    <h2>Новая запись</h2>
    <form action="{{ route('tables.notes-add', $project->id) }}" method="post">
        @csrf
        <textarea name="comment" placeholder="Введите текст заметки" required></textarea>
        <button type="submit">Создать</button>
    </form>
</div>