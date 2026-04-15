<div class="fixed bottom-6 right-6 z-50">
    <button id="chat-toggle" type="button"
        class="bg-blue-600 hover:bg-blue-700 text-white w-14 h-14 rounded-full shadow-lg text-2xl"
        aria-label="Abrir chat de recomendaciones">
        🤖
    </button>

    <div id="chatbot" class="hidden mt-3 w-[340px] bg-white rounded-2xl shadow-xl border border-blue-100 overflow-hidden">
        <div class="bg-[#004080] text-white px-4 py-3 font-semibold">
            Asistente NeusPhone
        </div>

        <div id="chat-mensajes" class="h-80 overflow-y-auto px-4 py-3 text-sm space-y-3 bg-blue-50">
            <div class="bg-white p-3 rounded-lg shadow-sm">
                Hola, soy tu asistente 🤖. Dime en que te puedo ayudar.
            </div>
        </div>

        <form id="chat-form" class="p-3 border-t bg-white">
            <div class="flex gap-2">
                <input id="chat-input" type="text" maxlength="500"
                    class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm"
                    placeholder="Ej: Busco un iPhone usado por 2 millones"
                    required>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    (() => {
        const toggleButton = document.getElementById('chat-toggle');
        const chatbox = document.getElementById('chatbot');
        const form = document.getElementById('chat-form');
        const input = document.getElementById('chat-input');
        const mensajes = document.getElementById('chat-mensajes');

        if (!toggleButton || !chatbox || !form || !input || !mensajes) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const appendMessage = (texto, esUsuario = false) => {
            const item = document.createElement('div');
            item.className = esUsuario
                ? 'bg-blue-600 text-white p-3 rounded-lg ml-8'
                : 'bg-white p-3 rounded-lg shadow-sm mr-8';
            item.textContent = texto;
            mensajes.appendChild(item);
            mensajes.scrollTop = mensajes.scrollHeight;
        };

        toggleButton.addEventListener('click', () => {
            chatbox.classList.toggle('hidden');
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const texto = input.value.trim();
            if (!texto) {
                return;
            }

            appendMessage(texto, true);
            input.value = '';

            const cargando = document.createElement('div');
            cargando.className = 'bg-white p-3 rounded-lg shadow-sm mr-8 text-gray-500';
            cargando.textContent = 'Pensando recomendacion...';
            mensajes.appendChild(cargando);
            mensajes.scrollTop = mensajes.scrollHeight;

            try {
                const response = await fetch('{{ route('chatbot.recomendar') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                    },
                    body: JSON.stringify({ mensaje: texto }),
                });

                const data = await response.json();
                cargando.remove();
                appendMessage(data.respuesta || 'No pude generar una recomendacion ahora.');
            } catch (error) {
                cargando.remove();
                appendMessage('Ocurrio un error al consultar el asistente. Intenta nuevamente.');
            }
        });
    })();
</script>
