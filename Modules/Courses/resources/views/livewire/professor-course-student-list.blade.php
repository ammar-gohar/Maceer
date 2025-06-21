<tr class="text-nowrap">
    <td>
        {{ $iteration }}
    </td>
    <td>
        {{ $enroll->student->full_name }}
    </td>
    <td>
        <input class="form-control" type="number" name="midterm" id="midterm" wire:model.blur='midterm' min="0" step="0.01">
    </td>
    <td>
        <input class="form-control" type="number" name="work" id="work" wire:model.blur='work' min="0" step="0.01">
    </td>
    <td>
        <input class="form-control" type="number" name="final" id="final" wire:model.blur='final' min="0" step="0.01">
    </td>
    <td class="text-center">
        {{ $enroll->total_mark }}
    </td>
</tr>
