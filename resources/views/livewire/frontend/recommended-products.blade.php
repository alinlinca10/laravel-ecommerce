<div>
    {{-- <form action="{!! route('addCart') !!}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{!! $product->id !!}">
        <input type="hidden" name="picture" value="{!! $imgs[0]->picture !!}">
        <input type="hidden" name="qty" value="1">
        <button type="submit" class="btn" wire:click="addToCart({{ $product->id }})">
            <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4.80547 8.69087C4.86368 7.90774 5.51605 7.30206 6.30134 7.30206H13.6987C14.484 7.30206 15.1364 7.90774 15.1946 8.69087L16.0084 19.6388C16.0731 20.5086 15.3848 21.25 14.5125 21.25H5.48755C4.61532 21.25 3.92703 20.5086 3.99168 19.6388L4.80547 8.69087Z" stroke="black"></path>
                <rect x="6.88892" y="7.51389" width="0.888889" height="13.5243" fill="black"></rect>
                <rect x="12.2223" y="7.51389" width="0.888889" height="13.5243" fill="black"></rect>
                <rect x="5.61121" y="5.16666" width="8.77778" height="1.84722" rx="0.5" stroke="black"></rect>
                <rect x="7.77783" y="10.3611" width="4.44445" height="0.711806" fill="black"></rect>
                <rect x="7.77783" y="13.2083" width="4.44445" height="0.711805" fill="black"></rect>
                <rect x="7.77783" y="16.0555" width="4.44445" height="0.711805" fill="black"></rect>
                <circle cx="17" cy="7" r="6.5" fill="black" stroke="white"></circle>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3128 3.49988L17.3124 10.5001L16.6874 10.5001L16.6878 3.49991L17.3128 3.49988Z" fill="white"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5001 7.31225L13.4999 7.31259L13.4999 6.68759L20.5001 6.68725L20.5001 7.31225Z" fill="white"></path>
              </svg>
        </button>
    </form> --}}
    <button type="button" class="btn" wire:click="addToCart({{ $product->id }})">
        <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.80547 8.69087C4.86368 7.90774 5.51605 7.30206 6.30134 7.30206H13.6987C14.484 7.30206 15.1364 7.90774 15.1946 8.69087L16.0084 19.6388C16.0731 20.5086 15.3848 21.25 14.5125 21.25H5.48755C4.61532 21.25 3.92703 20.5086 3.99168 19.6388L4.80547 8.69087Z" stroke="black"></path>
            <rect x="6.88892" y="7.51389" width="0.888889" height="13.5243" fill="black"></rect>
            <rect x="12.2223" y="7.51389" width="0.888889" height="13.5243" fill="black"></rect>
            <rect x="5.61121" y="5.16666" width="8.77778" height="1.84722" rx="0.5" stroke="black"></rect>
            <rect x="7.77783" y="10.3611" width="4.44445" height="0.711806" fill="black"></rect>
            <rect x="7.77783" y="13.2083" width="4.44445" height="0.711805" fill="black"></rect>
            <rect x="7.77783" y="16.0555" width="4.44445" height="0.711805" fill="black"></rect>
            <circle cx="17" cy="7" r="6.5" fill="black" stroke="white"></circle>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3128 3.49988L17.3124 10.5001L16.6874 10.5001L16.6878 3.49991L17.3128 3.49988Z" fill="white"></path>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5001 7.31225L13.4999 7.31259L13.4999 6.68759L20.5001 6.68725L20.5001 7.31225Z" fill="white"></path>
          </svg>
    </button>
</div>
