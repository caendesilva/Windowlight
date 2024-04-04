# About Windowlight

<h2 class="subheading">What is Windowlight?</h2>

**[Windowlight](https://windowlight.desilva.se)** is a code screenshot generator that uses [Torchlight](https://torchlight.dev) for syntax highlighting.

## How does it work?

Windowlight wraps the Torchlight API, providing a user-friendly interface to generate beautiful code screenshots, fully online - right from your browser.

We call Torchlight from our server, and then we display the result in a beautiful, customizable code window, that you can then download as a high quality PNG image.

Using Torchlight means that you can use their special directives, allowing you to add code highlights and annotations, and even Git diffs to your screenshots.


## Why use Windowlight?

### Features include:

- Probably the best syntax highlighting available
- Customizable code window with support for file labels
- High quality PNG images with support for ultra high resolutions
- Choose any background color, including transparent backgrounds
- Add annotations and highlights to your code, and even Git diffs
- Fully online and browser-based, no need to install anything
- [Open Source](https://github.com/caendesilva/Windowlight), and 100% free to use!

### Backed by the power of VS Code

Additionally, since Torchlight is powered by VS Code and TextMate, you get extremely accurate and feature rich syntax highlighting.
This includes support for virtually any programming language (over 100 languages supported, including PHP, JavaScript, Python, Ruby, Java, C++, C#, Swift, Go, Rust, and many, many more)

## Feedback

You can send feedback using the Twitter/X <a href="https://twitter.com/search?q=%23WindowlightApp" rel="nofollow" target="_blank">#WindowlightApp</a> hashtag, or through <a href="https://github.com/caendesilva/Windowlight/issues/new?title=Windowlight%20Feedback" rel="nofollow">GitHub Issues</a>.

### Security

If you need to report a security issue, please contact me directly at caen@desilva.se, with details at <a href="https://git.desilva.se/security/" rel="nofollow">git.desilva.se/security</a>.

## Terms and Conditions

### General Terms

To keep things nice and friendly for everyone, here is some stuff to keep in mind. I am not a lawyer and this is not legal advice. 
I created Windowlight because I wanted to use it myself, and I'm sharing it with you because I think you might find it useful too.
I'm acting in good faith and ask that you do as well.

### Usage Limits

To prevent abuse and excessive load on both my server and the Torchlight API, there are some very generous rate limits of **30 requests per minute** or **1000 requests per day**, whichever comes first.

### Privacy Policy

Windowlight does not store any of your code, or any of the images generated. We do store some basic analytics that are designed with privacy in mind.

**The analytics we collect are:**
- The number of page visits, the URL of the page visited, and the referrer domain.
- If the request is made by a bot, we will also store the user agent string.
- We do not store any IP addresses or any other personal information.
- We use a custom hashing algorithm to anonymize request identifiers, solely for the purpose of calculating unique visit counts. These cannot be reversed to identify individual users.

All analytics data is public and can be viewed at [https://windowlight.desilva.se/analytics](https://windowlight.desilva.se/analytics). Here you can also get information about how exactly the data is collected and processed.

As we do not store any personal information, we cannot provide any data deletion requests as there is no way to identify individual users.
You can verify, and improve, the source code of the anonymization algorithm on [GitHub](https://github.com/caendesilva/Windowlight/blob/main/app/Concerns/AnonymizesRequests.php).

### Who's behind Windowlight?

This service is created and provided by [Caen De Silva](https://twitter.com/CodeWithCaen), you can support me by [buying me a coffee](https://www.buymeacoffee.com/caen) if you like what I'm doing.

The official website for Windowlight is [https://windowlight.desilva.se](https://windowlight.desilva.se), and the source code is available on [GitHub](https://github.com/caendesilva/Windowlight), please show it some love by starring it!

PS: If you find this service on any other domain, it's not affiliated with me. On a related note, I'm not affiliated with Torchlight, but have gotten the go-ahead from it's creator Aaron to use their API for this project.
