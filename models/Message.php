<?php

class Message extends AbstractEntity
{

    private int $senderId;
    private int $receiverId;
    private string $content;
    private DateTime $sentAt;
    private bool $view;

    // Getter
    public function getSenderId(): int
    {
        return $this->senderId;
    }
    public function getReceiverId(): int
    {
        return $this->receiverId;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function getSentAt(): DateTime
    {
        return $this->sentAt;
    }
    public function isViewed(): bool
    {
        return $this->view;
    }

    // Setter
    public function setSenderId(int $senderId): void
    {
        $this->senderId = $senderId;
    }

    public function setReceiverId(int $receiverId): void
    {
        $this->receiverId = $receiverId;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    public function setSentAt(DateTime $sentAt): void
    {
        $this->sentAt = $sentAt;
    }

    public function setView(bool $view): void
    {
        $this->view = $view;
    }
}
