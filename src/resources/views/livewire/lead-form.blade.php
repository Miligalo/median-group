<div class="form-wrapper">

    @if ($submitted === true)
        <div class="alert alert--success">
            <span class="alert__icon">✅</span>
            <span>{{ $statusMessage }}</span>
        </div>
    @elseif ($submitted === false)
        <div class="alert alert--error">
            <span class="alert__icon">⚠️</span>
            <span>{{ $statusMessage }}</span>
        </div>
    @endif

    <form wire:submit="submit" class="form" novalidate>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label" for="name">
                    Name <span>*</span>
                </label>
                <input
                    class="form-input @error('name') form-input--error @enderror"
                    type="text"
                    id="name"
                    wire:model.live.debounce.400ms="name"
                    placeholder="Ivan Petrenko"
                    autocomplete="name"
                >
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="phone">
                    Phone <span>*</span>
                </label>
                <input
                    class="form-input @error('phone') form-input--error @enderror"
                    type="tel"
                    id="phone"
                    wire:model.live.debounce.400ms="phone"
                    placeholder="+380671234567"
                    autocomplete="tel"
                >
                @error('phone')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">
                Email <span>*</span>
            </label>
            <input
                class="form-input @error('email') form-input--error @enderror"
                type="email"
                id="email"
                wire:model.live.debounce.400ms="email"
                placeholder="ivan@example.com"
                autocomplete="email"
            >
            @error('email')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="message">Message</label>
            <textarea
                class="form-input @error('message') form-input--error @enderror"
                id="message"
                wire:model.live.debounce.400ms="message"
                placeholder="How can we help you?"
            ></textarea>
            @error('message')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn--primary" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="submit">Send Message</span>
            <span wire:loading wire:target="submit">
                <span class="spinner"></span>
                Sending...
            </span>
        </button>

    </form>
</div>
