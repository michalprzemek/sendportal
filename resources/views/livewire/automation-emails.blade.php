<div>
    <button wire:click="addEmail">Add Email</button>

    <form wire:submit.prevent="save">
        <table>
            <thead>
                <tr>
                    <th>Template</th>
                    <th>Delay (hours)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($emails as $index => $email)
                    <tr>
                        <td>
                            <select wire:model="emails.{{ $index }}.template_id">
                                @foreach ($templates as $template)
                                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" wire:model="emails.{{ $index }}.delay_in_hours">
                        </td>
                        <td>
                            <button wire:click.prevent="removeEmail({{ $index }})">Remove</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Save Changes</button>
    </form>
</div>
