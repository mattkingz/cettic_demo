using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class GameManager : MonoBehaviour {

    private static GameManager instance;
    public static GameManager Instance
    {
        get
        {
            if (!instance) instance = GameObject.FindObjectOfType<GameManager>();
            return instance;
        }
    }

    public float playerSpeed;
    public float levelTime;
    public float scorePerItem;

    public Player player;
    public Transform initialPosition;

    public GameObject prefabItemParticles;

    private float currentTime;
    private Transform lastCheckpoint;
    private bool isPlaying;
    private float score;
    private GameObject[] items;

    private string username;
    private int user_id;

	void Start () {
        items = GameObject.FindGameObjectsWithTag("Item");
        player.gameObject.SetActive(false);
	}

    public void RestartGame()
    {
        //Setup Player
        player.gameObject.SetActive(true);
        player.speed = playerSpeed;
        ChangePlayerPosition(initialPosition.position);

        //Activar los items
        foreach(GameObject item in items)
        {
            item.SetActive(true);
        }

        //setup game
        score = 0;
        isPlaying = true;
        currentTime = 0;
        lastCheckpoint = null;

        //Setup UI
        UIManager.Instance.ShowPanel(UIManager.Instance.panelGameplay);
        UIManager.Instance.SetScore(0);
        UIManager.Instance.SetTime(levelTime);

    }

    //Al agarrar un item se suma el puntaje y se desactiva el objeto
    //TODO: probablemente el efecto de particulas deberia estar en el prefab del item
    //TODO: una clase para ITEM
    public void ItemPickup(GameObject item)
    {
        score += scorePerItem;

        GameObject.Instantiate(prefabItemParticles, item.transform.position, Quaternion.identity);
        item.SetActive(false);

        //Update score ui
        UIManager.Instance.SetScore(score);

    }

    //Golpear un obstaculo devuelve al ultimo checkpoint
    public void ObstacleHit()
    {
        ChangePlayerPosition(lastCheckpoint != null ? lastCheckpoint.position : initialPosition.position);
    }

    public void CheckpointReach(Transform checkpoint)
    {
        lastCheckpoint = checkpoint;
    }

    //Funcion de ayuda que setea la posicion del jugador
    void ChangePlayerPosition(Vector3 newPosition)
    {
        player.GetComponent<Rigidbody>().velocity = Vector3.zero;
        player.GetComponent<Rigidbody>().angularVelocity = Vector3.zero;

        player.GetComponent<TrailRenderer>().Clear();

        player.transform.position = newPosition;
    }

    public void FinishReach()
    {
        GameOver("Level Completed!");
    }

    public void GameOver(string message = "Game Over")
    {
        isPlaying = false;
        player.gameObject.SetActive(false);
        UIManager.Instance.ShowGameOver(score, message);

        //post score to DB
        DatabaseConnection.Instance.PostScore(user_id.ToString(), score.ToString());

    }
	
	void Update () {
		
        //Timer
        if(isPlaying)
        {
            currentTime += Time.deltaTime;
            UIManager.Instance.SetTime(levelTime - currentTime);

            if(currentTime >= levelTime)
            {
                GameOver();
            }

        }

	}

    public void LoggedIn(string user, int id)
    {
        username = user;
        user_id = id;

        //download game config
        DatabaseConnection.Instance.UpdateGameConfig();
    }

}
