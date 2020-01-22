<tr>
    <td></td>
    <td>
        {{ $indicator->name }}
        <input type="hidden" name="indicator[]" value="{{ $indicator->id }}" class="indicator" />
    </td>
    <td>
        {{ $data['cross_check_1_a']->name }}
        <input type="hidden" name="indicator[]" value="{{ $indicator->id }}" class="indicator" />
    </td>
</tr>